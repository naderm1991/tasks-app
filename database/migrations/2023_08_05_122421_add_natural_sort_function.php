<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNaturalSortFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (config('database.default') === 'mysql') {
            // https://www.drupal.org/project/natsort
            DB::unprepared("CREATE FUNCTION natural_sort (s varchar(255)) RETURNS varchar(255) " .
                "no sql DETERMINISTIC
            begin
                declare orig varchar(255) default s;
                declare ret varchar(255) default '';
                if s is null then
                    return null;
                elseif not s regexp '[0-9]' then
                    set ret = s;
                else
                    set s = replace(
                        replace(
                            replace(
                                replace(
                                    replace(s,'0','#'),'1','#'
                                ),'2','#'
                            ),'3','#'
                        ),'4','#'
                    );
                    set s = replace(
                        replace(
                            replace(
                                replace(
                                    replace(s,'5','#'),'6','#'
                                ),'7','#'
                            ),'8','#'
                        ),'9','#'
                    );
                    set s = replace(s,'.#','##');
                    set s = replace(s,'#,#','###');
                    begin
                        declare num_pos int;
                        declare num_len int;
                        declare num_str varchar(255);
                        lp1: loop
                            set num_pos = locate('#',s);
                            if num_pos = 0 then
                                set ret = concat(ret,s);
                                leave lp1;
                            end if;
                            set ret = concat(ret, substring(s, 1, num_pos - 1));
                            set s = substring(s, num_pos);
                            set orig = substring(orig, num_pos);

                            set num_len = char_length(s) - char_length(trim(leading '#' from s));
                            set num_str = cast(replace(substring(orig, 1, num_len), ',', '') as decimal(13,3));
                            set num_str = lpad(num_str, 15, '0');
                            set ret = concat(ret, '[', num_str, ']');
                            set s = substring(s, num_len + 1);
                            set orig = substring(orig, num_len + 1);
                        end loop;
                    end;
                end if;
                set ret = replace(
                    replace(
                        replace(
                            replace(
                                replace(
                                    replace(
                                        replace(ret, ' ',''), ',', ''
                                    ) ,':',''
                                ) ,'.',''
                            ) ,';',''
                        ) ,'(',''
                    ) ,')',''
                );
                return ret;
            end
            "
            );
        }

        if(config('database.default') === 'pgsql'){
            DB::unprepared(
                'create or replace function natural_sort(text)
                returns bytea language sql immutable strict as
                $f$
                select
                    string_agg(
                        convert_to(
                            coalesce(
                                r[2], length( length(r[1])::text ) || length(r[1])::text || r[1]
                            ),
                            \'UTF8\'
                        ),
                        \'\x00\'
                    )
                from regexp_matches( $1,\'0*([0-9]+)|([^0-9]+)\', \'g\' ) r; $f$;
            ');

            Schema::table('devices', function (Blueprint $table) {
                $table->rawIndex('(natural_sort(name))', 'name_sort_index');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $query = 'DROP FUNCTION IF EXISTS natural_sort';
        if (config('database.default') === 'pgsql') {
            //todo add "cascade" in case of psql only
            $query = 'DROP FUNCTION IF EXISTS natural_sort(text) CASCADE';
        }
        DB::unprepared($query);

    }
}
