#!/bin/bash
# test vm pulling sh

ssh -p22 -i ~/.ssh/centos66rsa vagrant@centos66 <<SHELL
cd /var/www/html/force
mkdir aa
SHELL
