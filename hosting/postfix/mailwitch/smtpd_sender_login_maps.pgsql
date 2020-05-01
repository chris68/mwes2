#
# pgsql config file for local(8) aliases(5) lookups
#

# The user name and password to log into the psql server.
user = mailwitch
password = mailwitch

# The database name on the servers.
dbname = mwes2

# The table name.
table = postfixsenderwithsasl

# Query components, see below.
select_field = Sender
where_field = Sender

# You may specify additional_conditions or leave this empty.
additional_conditions = 

