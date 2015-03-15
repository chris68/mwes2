#
# mysql config file for local(8) aliases(5) lookups
#

# The user name and password to log into the psql server.
user = mailwitch
password = mailwitch

# The database name on the servers.
dbname = mwes2

# The table name.
table = postfixrecipientaliases

# Query components, see below.
select_field = Target
where_field = Source

# You may specify additional_conditions or leave this empty.
additional_conditions = and not isvirtual
