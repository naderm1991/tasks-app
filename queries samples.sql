
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


---------------


select

`users`.`id`, `users`.`name`, `company_id`, `email`,
       (select `id` from `logins` where `user_id` = `users`.`id` order by `created_at` desc limit 1) as `last_login_id`
from `users`

where (`users`.`name` like 'Kennedy%' or `company_id` in (select `id` from `companies` where `companies`.`name` like 'Kennedy%'))

and (`users`.`name` like 'Aaliyah Abernathy%' or `company_id` in (select `id` from `companies` where `companies`.`name` like 'Aaliyah Abernathy%')) order by `name` asc limit 15 offset 0

-------------

Lesson 10 - When it makes sense to run additional queries


select
`users`.`id`, `users`.`name`, `company_id`, `email`, (select `id` from `logins` where `user_id` = `users`.`id` order by `created_at` desc limit 1) as `last_login_id`
from `users` where
(

    `users`.`name` like 'Aaliyah Abernathy%' or `company_id` in ( select `id` from `companies` where `companies`.`name` like 'Aaliyah Abernathy%')
)
order by `name` asc limit 15 offset 0


----

select

`users`.`id`, `users`.`name`, `company_id`, `email`, (select `id` from `logins` where `user_id` = `users`.`id` order by `created_at` desc limit 1) as `last_login_id`
from `users`
where
(`users`.`name` like 'Aaliyah Abernathy%' or `company_id` in (select `id` from `companies` where `companies`.`name` like 'Aaliyah Abernathy%'))
and
(`users`.`name` like 'Kennedy%' or `company_id` in (select `id` from `companies` where `companies`.`name` like 'Kennedy%'))

order by `name` asc limit 15 offset 0

--------


select `id` from `companies` where `companies`.`name` like 'Kennedy%'

-----

select
`users`.`id`, `users`.`name`, `company_id`, `email`, (select `id` from `logins` where `user_id` = `users`.`id` order by `created_at` desc limit 1) as `last_login_id`
from `users`
where
    (`users`.`name` like 'Aaliyah Abernathy%')
  and
    (`users`.`name` like 'Kennedy%' or `company_id` in (4720,3365,9997))

order by `name` asc limit 15 offset 0;

_____________________

Lesson 11 - Using UNIONs to run queries independently

select * from `users` where `first_name` like 'Kennedy%' or last_name like 'Kennedy%'

explain select * from `users` where ``.`name` like 'Kennedy%';

explain
select *
from users
inner join companies on users.company_id = companies.id
where companies.name like 'Kennedy%';

explain
select *
from users
where first_name like 'Kennedy%' or last_name like 'Kennedy%'

union

select user.*
from users
inner join companies on users.company_id = companies.id
where companies.name like 'bill%';

-- wrong way to do it
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
)
