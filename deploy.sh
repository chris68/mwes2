#!/bin/bash
env=""
stage="yes"
migrate="yes"
branch="master"
while getopts "b:m:s:e:" optname
  do
    case "$optname" in
      "e")
        env=$OPTARG
		case "$env" in
		  "Development")
			suffix="_dev"
			;;
		  "Production")
			suffix=""
			;;
		  *)
			echo "-e requires either 'Production' or 'Development' as parameter"
			exit 1
			;;
		esac
        ;;
      "b")
        branch=$OPTARG
        ;;
      "s")
        stage=$OPTARG
		case "$stage" in
		  "yes")
			;;
		  "no")
			;;
		  *)
			echo "-s (stage) requires either 'yes' or 'no' as parameter"
			exit 1
			;;
		esac
        ;;
      "m")
        migrate=$OPTARG
		case "$migrate" in
		  "yes")
			;;
		  "no")
			;;
		  *)
			echo "-m (migrate) requires either 'yes' or 'no' as parameter"
			exit 1
			;;
		esac
        ;;
      "?")
        echo "Unknown option $OPTARG"
        ;;
      ":")
        echo "No argument value for option $OPTARG"
        ;;
      *)
        echo "Unknown error while processing options"
        ;;
    esac
  done
if [ "$env" == "" ]; then
	echo "Parameter -e (environment) must be given"
	exit 1
fi
echo Deploying to $env
rm -R -f /home/mailwitch/mwes2$suffix #remove old
git clone https://github.com/chris68/mwes2 /home/mailwitch/mwes2$suffix
{ cd /home/mailwitch/mwes2$suffix; git checkout $branch; }
# psql postgres #create the database (see migration)
# psql postgres #CREATE DATABASE mwes2_dev WITH TEMPLATE mwes2; (for Development test)
sudo -H composer self-update
composer create-project -d /home/mailwitch/mwes2$suffix 

/home/mailwitch/mwes2$suffix/init --env=$env
if [ "$migrate" == "yes" ]; then
    /home/mailwitch/mwes2$suffix/yii migrate
fi
if [ "$stage" == "yes" ]; then
	sudo rm -R /var/opt/mailwitch/www/mwes2$suffix
	sudo cp -R /home/mailwitch/mwes2$suffix /var/opt/mailwitch/www/.
	sudo rm -R /var/opt/mailwitch/www/mwes2$suffix/.git
	sudo chown -R www-data:mailwitch /var/opt/mailwitch/www/mwes2$suffix
fi
# rm -R -f /home/mailwitch/mwes2$suffix #remove again.
