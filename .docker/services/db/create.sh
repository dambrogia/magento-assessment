# Creates a new docker database image and tags it to the date
# If you pass a file in ./imports. It will use that as the database dump
# in the newly created docker db image.
date=$(date +"%Y-%m-%d")
tag="local_db:db-${date}"
container_name="db"
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
cwd=$(pwd);
cd ${DIR}

if [[ "$1" != "" && -f ${DIR}/imports/${1} ]]; then
    # If import file is supplied && it exists

    [ -f import.sql.tgz ] && rm import.sql.tgz
    ln -s imports/${1} import.sql.tgz
    echo "Using imports/${1} as import file"
elif [[ "$1" != "" && ! -f ${DIR}/imports/${1} ]]; then
    # If import file is supplied && it is missing
    echo "Supplied import file doesn't exist:"
    echo "${DIR}/imports/${1}";
else
    echo "No import file supplied [OK]."
fi

docker build --tag ${tag} .

docker run -id --name ${container_name} \
    -e MYSQL_USER=docker \
    -e MYSQL_PASSWORD=docker \
    -e MYSQL_DATABASE=mage \
    -e MYSQL_RANDOM_ROOT_PASSWORD=yes \
    ${tag}

echo "Waiting for mysql service to start."
sleep 10;

echo "Importing database."
time docker exec -i ${container_name} /bin/bash -c "mysql -udocker -pdocker mage < /tmp/import.sql; rm /tmp/import.sql"
sleep 5;

echo "Committing ${container_name} container: ${tag}"
docker commit -m "Dev database ${date}" ${container_name} ${tag}

cd ${cwd}
