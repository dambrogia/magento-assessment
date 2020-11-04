# This has been copy/pasted in from the parent repository with minimal adjustments.
# The following is kept for reference, but the use case may differ from the original repo.
_________

# Docker Local Environment

This is a local environment including web and database servers. There
is an example docker-compose file that you can copy and make a few small tweaks
to so that it fits your needs. There is also shell script to help create a
database image from an .sql.tgz import.w

The instructions you see assume you have docker & docker compose installed on
your host machine. For a high level overview and installation instructions
visit the first link in the table of contents.

## Table of Contents

 - [Creating a database image](#creating-a-database-image)
 - [Configure your docker-compose file](#configure-your-docker-compose-file)
 - [Volume mounts vs SFTP](#volume-mounts-vs-sftp)
 - [Credentials for `app/etc/local.xml`](#credentials)
 - [Running Docker + Docker Compose](#running-docker--docker-compose)

___

#### Creating a Database Image
Add a .sql.tgz dump of the database into `services/db/imports`. Name it however
you'd like (dates might help). Your collection of imports will be ignored by
git. If you specify an import file (relative to `services/db/imports`) when
running the script, a symlink (`services/db/import.sql.tgz`) will be made to
that file and that import will be built into your docker database image.

As an example we'll assume you have a database dump at `services/db/imports/db_import.sql.tgz`.
If you run the following, in about 5 minutes you'll have a docker database
image ready to use.

    ./services/db/create.sh db_import.sql.tgz

Run the following to see your available images:

    docker image ls

___

#### Configure your docker-compose file
A `docker-compose-example.yml` file is used so that you can make changes to your
`docker-compose.yml` file and not be bugged by git for your changes. There's a
few small notes and changes available to you, but for the most part specify your
database image (the one you just created) and the paths you want to mount as
volumes and you should be good to go.

    cp docker-compose-example.yml docker-compose.yml

___

#### Volume mounts vs SFTP
Mac and Windows have _terrible_ performance for file mounting on Docker. This
isn't a docker issue, it's an OS issue. Linux has great speeds, can (and should)
utilize mounting volumes into containers.

If you are running Mac or Windows, you can mount a few files (Apache configs, SSH keys, etc.), but if you attempt to mount your repository [you're gonna have a bad time](http://www.quickmeme.com/img/07/078e225b71ed630f71f7bb2999731514a17472f50b0ab0c1be5a32c9a25e6238.jpg).
OpenSSH Server is installed on the web container and port 22 on your container is
mapped to 2222 on your host. Along with mapping your `~/.ssh/id_rsa.pub` of your
host machine into your `~/.ssh/authorized_keys` of your container / guest you can
ssh like so:

    ssh -p 2222 root@localhost

Setting up the following in `~/.ssh/config` on your host machine will allow for easy rsync, ssh and sftp:

    Host localhost
        HostName localhost
        Port 2222
        User root
        IdentityFile ~/.ssh/id_rsa

You could then ssh, sftp and rsync like so:

    ssh localhost
    scp localhost:<guest_source_file> <host_destination>
    rsync <flags> localhost:<guest_source_dir> <host_destination_dir>

___

#### Credentials

The host name will match the name of the container. The container names are specified in the `docker-compose.yml` file.

Database Credentials:
 - Host: db
 - User: docker
 - Pass: docker
 - Database: mage

Urls:
 - Frontebd: http://localhost
 - Admin: http://localhost/admin

___

#### Running Docker + Docker Compose
You must run docker-compose files in the root of this repository. They expect a `docker-compose.yml` file (unless specified otherwise) to exist in the current
directory.

Docker must be running. For Mac or Windows, locate the application and start it.
On Ubuntu:

    sudo systemctl start docker
    # or
    sudo service docker start

After editing your `docker-compose.yml` file, run the following.

    docker-compose up -d

To bring down your containers (which will delete any state that exists in them):

    docker-compose down

To pause your services (will maintain state after unpaused):

    docker-compose pause
    docker-compose unpause

If you run into issues, open an issue or ping someone on slack! :thumbsup:
