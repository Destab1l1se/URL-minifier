In order to make this project work properly  you should have <strong>browscap</strong>
configured in you php.ini.

To deploy database run
<code> php artisan migrate --seed</code>

There is table 'redis_imitation' in database, it contains only one row.
I decided to make such architectural decision because deploying redis for
such a small project  is redundant (in my opinion).