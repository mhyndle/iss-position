#!/usr/bin/env bash
###################################################
echo "Installing:"

apt-get update && apt-get upgrade -y > /dev/null 2>&1
apt-get install -y python-software-properties > /dev/null 2>&1
LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php > /dev/null 2>&1

apt-get update > /dev/null 2>&1

###################################################

echo "- PHP 7.2"

apt-get install -y php7.2 > /dev/null 2>&1

###################################################

echo "- Apache2"
apt-get install -y apache2 > /dev/null 2>&1

a2dissite 000-default.conf > /dev/null 2>&1

cp /vagrant/vagrantConfig/apache2-virtual-host /etc/apache2/sites-available/iss-position.loc.conf
a2ensite iss-position.loc.conf > /dev/null 2>&1

a2enmod rewrite > /dev/null 2>&1

service apache2 restart > /dev/null 2>&1

###################################################

echo "- some other stuff"
apt-get install -y --force-yes php-pear php7.2-curl php7.2-dev php7.2-mbstring php7.2-xml libapache2-mod-php7.2 php7.2-json php-xdebug > /dev/null 2>&1

###################################################

echo "- GIT"
apt-get install -y git > /dev/null 2>&1

echo "- Composer"
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer > /dev/null 2>&1

###################################################
echo "Installation process FINISHED"

echo "__________________________________________________________________"
echo "    ______              ______                 _ _                "
echo "   (______)            / _____)               | | |               "
echo "    _     _ _____ _   ( (____  _____ ____   __| | |__   ___ _   _ "
echo "   | |   | | ___ | | | \____ \(____ |  _ \ / _  |  _ \ / _ ( \ / )"
echo "   | |__/ /| ____|\ V /_____) ) ___ | | | ( (_| | |_) ) |_| ) X ( "
echo "   |_____/ |_____) \_/(______/\_____|_| |_|\____|____/ \___(_/ \_)"
echo "__________________________________________________________________"
echo ""
echo "check it on https://github.com/mhyndle"