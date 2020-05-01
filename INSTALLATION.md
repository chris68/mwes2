## Php ##
Php >= 5.4 is required
### Further modules ###
The following modules are needed. Install/Activate them via

```
None
```
## Postgres ##
Postgres 9.5 is used.
## Postfix and Dovecot ##
### Dovecot ###
In ``/etc/dovecot/conf.d\10-auth.conf`` exclude ``auth-system`` and include ``auth-sql``, i.e:
```
!include auth-system.conf.ext
#!include auth-sql.conf.ext
#!include auth-ldap.conf.ext
#!include auth-passwdfile.conf.ext
#!include auth-checkpassword.conf.ext
#!include auth-vpopmail.conf.ext
#!include auth-static.conf.ext
```
to 
```
#!include auth-system.conf.ext
!include auth-sql.conf.ext
#!include auth-ldap.conf.ext
#!include auth-passwdfile.conf.ext
#!include auth-checkpassword.conf.ext
#!include auth-vpopmail.conf.ext
#!include auth-static.conf.ext
```

Add ``dovecot-dict-sql.conf.ext`` to the end of ``/etc/dovecot/dovecot-sql.conf.ext`` (not /etc/dovecot/dovecot-**dict**-sql.conf.ext).  

Change the socket config in ``/etc/dovecot/conf.d/10-master.conf`` from
```
service auth {
  # auth_socket_path points to this userdb socket by default. It&apos;s typically
  # used by dovecot-lda, doveadm, possibly imap process, etc. Users that have
  # full permissions to this socket are able to get a list of all usernames and
  # get the results of everyone&apos;s userdb lookups.
  #
  # The default 0666 mode allows anyone to connect to the socket, but the
  # userdb lookups will succeed only if the userdb returns an &quot;uid&quot; field that
  # matches the caller process&apos;s UID. Also if caller&apos;s uid or gid matches the
  # socket&apos;s uid or gid the lookup succeeds. Anything else causes a failure.
  #
  # To give the caller full permissions to lookup all users, set the mode to
  # something else than 0666 and Dovecot lets the kernel enforce the
  # permissions (e.g. 0777 allows everyone full permissions).
  unix_listener auth-userdb {
    #mode = 0666
    #user = 
    #group = 
  }

  # Postfix smtp-auth
  #unix_listener /var/spool/postfix/private/auth {
  #  mode = 0666
  #}

  # Auth process is run as this user.
  #user = $default_internal_user
}
```
to
```
service auth {
  # auth_socket_path points to this userdb socket by default. It&apos;s typically
  # used by dovecot-lda, doveadm, possibly imap process, etc. Users that have
  # full permissions to this socket are able to get a list of all usernames and
  # get the results of everyone&apos;s userdb lookups.
  #
  # The default 0666 mode allows anyone to connect to the socket, but the
  # userdb lookups will succeed only if the userdb returns an &quot;uid&quot; field that
  # matches the caller process&apos;s UID. Also if caller&apos;s uid or gid matches the
  # socket&apos;s uid or gid the lookup succeeds. Anything else causes a failure.
  #
  # To give the caller full permissions to lookup all users, set the mode to
  # something else than 0666 and Dovecot lets the kernel enforce the
  # permissions (e.g. 0777 allows everyone full permissions).
  unix_listener auth-userdb {
    #mode = 0666
    #user = 
    #group = 
  }

  # Postfix smtp-auth -- see http://www.postfix.org/SASL_README.html
  unix_listener /var/spool/postfix/private/auth {
    mode = 0660
    user = postfix
    group = postfix
  }

  # Auth process is run as this user.
  #user = $default_internal_user
}
```
by replacing the lines under Postfix smtp-auth.
### Postfix ###
See hosting/postfix and the respective deploy.sh
## OAUTH ##
The oauth file looks as follows. The <> has to be replaced by the respective credentials

```
[google]
clientId="<>"
clientSecret="<>"
```

