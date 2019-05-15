#!/bin/sh
# wait until MySQL is really available
maxcounter=45

counter=1
while ! docker-compose exec -T mysql sh -c "mysql -uroot -hmysql -e\"show databases;\" > /tmp/test.sql" > /dev/null 2>&1; do
    sleep 1
    counter=`expr $counter + 1`
    if [ $counter -gt $maxcounter ]; then
        >&2 echo "We have been waiting for MySQL too long already; failing."
        docker-compose logs db
        exit 1
    fi;
done
