while [ true ]
do
  queues=$(ps aux| grep -v grep| grep queue=codebash | wc -l);
  if [ "$queues" -lt "1" ]; then

   php artisan queue:work database --queue=codebash > codebash.log&
  fi
  sleep 60
done
