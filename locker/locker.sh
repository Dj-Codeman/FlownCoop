#!/bin/bash
# ! This has to run at least every 3 seconds
# ! Any longer and we risk all images not being
# ! unlocked when the user needs them

mv /tmp/locker/write /tmp/locker/activew
mv /tmp/locker/read /tmp/locker/activer

bash /tmp/locker/activew
bash /tmp/locker/activer

rm -v /tmp/locker/activew
rm -v /tmp/locker/activer

 
