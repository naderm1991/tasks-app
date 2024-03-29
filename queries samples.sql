
select
    `users`.`id`,
    `users`.`name`,
    `company_id`,
    `email`,
    (select `id` from `logins` where `user_id` = `users`.`id` order by `created_at` desc limit 1) as `last_login_id`

from `users`
where

(
    `users`.`name` like 'Aaliyah Abernathy%' or
    `company_id` in ( select `id` from `companies` where `companies`.`name` like 'Aaliyah Abernathy%' )
)

order by `name` asc limit 15 offset 0

---
homework:

select `users`.`id`, `users`.`name`, `company_id`, `email`, (select `id` from `logins` where `user_id` = `users`.`id` order by `created_at` desc limit 1) as `last_login_id`
from `users`
where

(
    `users`.`name` like 'Kennedy%' or
    `company_id` in (select `id` from `companies` where `companies`.`name` like 'Kennedy%') and
    `users`.`name` like 'Aaliyah Abernathy%' or
    `company_id` in (select `id` from `companies` where `companies`.`name` like 'Aaliyah Abernathy%')
)


order by `name` asc limit 15 offset 0


-------------------------------------------------------------------------------


select

`users`.`id`, `users`.`name`, `company_id`, `email`,
       (select `id` from `logins` where `user_id` = `users`.`id` order by `created_at` desc limit 1) as `last_login_id`
from `users`

where (`users`.`name` like 'Kennedy%' or `company_id` in (select `id` from `companies` where `companies`.`name` like 'Kennedy%'))

and (`users`.`name` like 'Aaliyah Abernathy%' or `company_id` in (select `id` from `companies` where `companies`.`name` like 'Aaliyah Abernathy%')) order by `name` asc limit 15 offset 0

________________________________________________________________________________


select
`users`.`id`, `users`.`name`, `company_id`, `email`, (select `id` from `logins` where `user_id` = `users`.`id` order by `created_at` desc limit 1) as `last_login_id`
from `users` where
(
 `users`.`name` like 'Aaliyah Abernathy%' or `company_id` in ( select `id` from `companies` where `companies`.`name` like 'Aaliyah Abernathy%')
)
order by `name` asc limit 15 offset 0

# use "and"

select

`users`.`id`, `users`.`name`, `company_id`, `email`, (select `id` from `logins` where `user_id` = `users`.`id` order by `created_at` desc limit 1) as `last_login_id`
from `users`
where
(`users`.`name` like 'Aaliyah Abernathy%' or `company_id` in (select `id` from `companies` where `companies`.`name` like 'Aaliyah Abernathy%'))
and
(`users`.`name` like 'Kennedy%' or `company_id` in (select `id` from `companies` where `companies`.`name` like 'Kennedy%'))

order by `name` asc limit 15 offset 0

_________________________________________________

# "Lesson 10 - When it makes sense to run additional queries"


select `id` from `companies` where `companies`.`name` like 'Kennedy%'

select
`users`.`id`, `users`.`name`, `company_id`, `email`, (select `id` from `logins` where `user_id` = `users`.`id` order by `created_at` desc limit 1) as `last_login_id`
from `users`
where
    (`users`.`name` like 'Aaliyah Abernathy%')
  and
    (`users`.`name` like 'Kennedy%' or `company_id` in (4720,3365,9997))

order by `name` asc limit 15 offset 0;

_____________________

# "Lesson 11 - Using UNIONs to run queries independently"

# used queries

select * from `users` where `first_name` like 'Kennedy%' or last_name like 'Kennedy%';

select * from users inner join companies on users.company_id = companies.id where companies.name like 'Kennedy%';

explain: the queries

select users.* from users inner join companies on users.company_id = companies.id where companies.name like 'Kennedy%';

# "use unions"
select *
from users
where first_name like 'Kennedy%' or last_name like 'Kennedy%'

union

select user.*
from users
inner join companies on users.company_id = companies.id
where companies.name like 'bill%';

-- wrong way to do it
# "use unions inside of in subquery"
explain select * from `users` where id in (
select id
from `users`
where `first_name` like 'Kennedy%' or `last_name` like 'Kennedy%'
union
select users.id
from `users`
inner join `companies` on `users`.`company_id` = `companies`.`id`
where `companies`.`name` like 'Kennedy%'
)

-- right way to do it "derived table"
# use "unions and derived table"
explain select * from `users` where id in (
select id from (select id
                    from `users`
                    where `first_name` like 'Kennedy%'
                       or `last_name` like 'Kennedy%'
                    union
                    select users.id
                    from `users`
                             inner join `companies` on `users`.`company_id` = `companies`.`id`
                    where `companies`.`name` like 'Kennedy%'
    ) as matches
);

-- with and
explain select * from `users` where
id in (
    select id from (select id
                    from `users`
                    where `first_name` like 'Kennedy%'
                       or `last_name` like 'Kennedy%'
                    union
                    select users.id
                    from `users`
                             inner join `companies` on `users`.`company_id` = `companies`.`id`
                    where `companies`.`name` like 'Kennedy%'
    ) as matches
)
and id in (
   select id from (
        select id
        from `users`
        where `first_name` like 'microsoft%' or `last_name` like 'microsoft%'
        union
        select users.id
        from `users`
        inner join `companies` on `users`.`company_id` = `companies`.`id`
        where `companies`.`name` like 'microsoft%'
        ) as matches
);

------------------------------------------------------------------------------------------------------------------------

# "Lesson 14 - Faster ordering using compound indexes"

explain select
`users`.`id`, `users`.`first_name`, `users`.`last_name`, `users`.`name`, `company_id`, `email`,(select `id` from `logins` where `user_id` = `users`.`id` order by `created_at` desc limit 1) as `last_login_id`
from `users` order by `name` asc, `last_name` asc, `first_name` asc limit 15 offset 0
;

select `users`.* from `users` order by (select `name` from `companies` where `id` = `users`.`company_id` order by `name` asc) asc limit 15 offset 0


select `users`.* from `users` inner join `companies` on `companies`.`id` = `users`.`company_id` order by `companies`.`name` asc limit 15 offset 0

------------------------------------------------------------------------------------------------------------------------

# "Lesson 21 - Filtering and sorting anniversary dates"

SELECT
    "1972-08-01" + interval ( year("2023-07-31") - year("1972-08-01") ) year,
    "2023-07-31",
    "1972-08-01" + interval (year("2023-07-31") - year("1972-08-01")) year,
    "1972-08-01" + interval (year("2023-07-31") - year("1972-08-01")) + 1 year
;

select
    *
from
    `users`
where
    date_format(birth_date,"%m-%d")
in
    ('07-31','08-01','08-02' ,'08-03','08-04','08-05' ,'08-06')
-- order by
--     date_format(birth_date,"%m-%d"),
--     name asc
limit 15 offset 0;

------------------------------------------------------------------------------------------------------------------------

# "Lesson 24 - Full text search with ranking"

select id, title
from posts
where match(title, body) against('fox' in boolean mode)
_______

select id, title, match(title, body) against('quick brown fox' in boolean mode) as score
from posts
where match(title, body) against('quick brown fox' in boolean mode)



























