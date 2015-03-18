#!/bin/bash
if [ "$UID" -ne "0" ]; then
  echo You must be root to run this script.
  exit 1
fi

function check_error()
{
  local exit_code=$?
  if [ $exit_code -ne 0 ]; then
    echo "$PWD [$0]: Last command failed (exit code $exit_code) - now aborting"
    exit 1
  fi
}

if test -e /etc/postfix/mailwitch; then
  rm -R /etc/postfix/mailwitch || check_error
fi
mkdir /etc/postfix/mailwitch || check_error
chown postfix:postfix /etc/postfix/mailwitch || check_error
chmod 755 /etc/postfix/mailwitch  || check_error

cp mailwitch/*.{hash,regexp,pgsql} /etc/postfix/mailwitch/. || check_error
# Append the config file in order not to overwrite the existing one
cat main.cf >> /etc/postfix/main.cf || check_error

# postfix must be able to read the files: but only postfix should be allowed
chown postfix:postfix /etc/postfix/mailwitch/* || check_error
chmod 664 /etc/postfix/mailwitch/*  || check_error

# Build up the mappings db (currently not needed)
#postmap /etc/postfix/mailwitch/*.hash || check_error

echo "Postfix configuration deployed. Do not forget to edit/reconcile the configuration file via"
echo "sudo nano /etc/postfix/main.cf"