
##!/bin/bash

#ssh ubuntu@184.72.85.188 '/opt/lampp/bin/mysql -h "184.72.85.188" -u "root" "-proot" -e "STOP SLAVE;"'

masterOriginal="107.20.120.198"
masterBackup="184.72.85.188"
localhost="54.242.184.151"
export currentMaster=0

extractMasterHost()
{
	 result=`/opt/lampp/bin/mysql -h "$localhost" -u "root" "-proot" -e "SHOW SLAVE STATUS\G;" | grep Master_Host`
	 set -- $result
	 export currentMaster=$2
}

switch()
{
	 echo "Swithching to $1"
	 result=`/opt/lampp/bin/mysql -h "$localhost" -u "root" "-proot" -e "STOP SLAVE;CHANGE MASTER TO MASTER_HOST='$1';RESET SLAVE;START SLAVE;"`
}

checkMasterStatus()
{
       
	extractMasterHost
	echo "Current Master is $currentMaster"
	test='mysqld is alive'
	primaryMasterStatus=`/opt/lampp/bin/mysqladmin -h "$masterOriginal" -u "root" "-proot" ping`
	backupMasterStatus=`/opt/lampp/bin/mysqladmin -h "$masterBackup" -u "root" "-proot" ping`
	if [ "$currentMaster" = "$masterBackup" ] && [ "$test" = "$primaryMasterStatus" ]
	then
		switch $masterOriginal
	fi
	if [ "$test" != "$primaryMasterStatus" ] && [ "$currentMaster" = "$masterOriginal" ]
        then
                switch $masterBackup
        fi

}
checkMasterStatus

