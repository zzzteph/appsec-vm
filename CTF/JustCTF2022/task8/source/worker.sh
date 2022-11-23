while [ true ]
do

  queues=$(ps aux| grep -v grep| grep "queue:work database" | wc -l);
  if [ "$queues" -lt "2" ]; then

   php artisan queue:work database --sleep=3 >screen.log &
  fi


  sleep 1
done
