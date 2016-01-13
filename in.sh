#!/usr/bin/expect
expect -c "
set timeout 5
spawn git pull
expect \"Enter passphrase for key '/home/vagrant/.ssh/id_rsa':\"
send \"bnm26cvb\n\"
interact
"
