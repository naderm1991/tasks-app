
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
