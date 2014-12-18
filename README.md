Development environment for SC Ymall Shopping SRL - let's evolve
===

 <p> <strong>Must have:</strong> </p>
 <ul> 
	 <li> local server, php, mysql, xampp </li>
	 <li> magento installed </li>
	 <li> latest database </li>
 </ul>

 <p> <strong>Magento filese and database to install on localhost:</strong> </p>
 <ul> 
	 <li> magento files : http://data.ymall.ro/dev.zip </li>
	 <li> magento db : http://data.ymall.ro/ymall.sql.gz </li>
	 <li> Access info : user -> ymalldata ; pass -> =%T@5?ehN~Pv </li>
 </ul>

 <p> <strong>Instructions on how to configure magento and the database on a localhost, for example in xampp :</strong> </p>
 <ul> 
	 <li> <strong>DATABASE CONFIG</strong> </li>
	 <li> 1. copy the files inside the htdocs folder of xampp </li>
	 <li> 2. create a blank database </li>
	 <li> 3. import inside the blank database the .sql file you downloaded from the above link </li>
	 <li> 4. once imported find the "core_config_data" table and inside it you will find(search if you don't see them) 2 records which contain the following link : "http://ymall.ro/" </li>
	 <li> 5. change the 2 records with the url you will access it on your local host. Example in xampp : http://127.0.0.1/ymall/ </li>
	 <li> <strong>IMPORTANT : when you change the 2 records in the database the new url allways must have "http://" and at the end of it "/" </strong><br/></li>
	 <li> <strong>FILES CONFIG</strong> </li>
	 <li> 1. inside the magento files under : 'app/etc/' open the 'local.xml' file and add the new -> username, database name, and pass so the magento can connect to your local database. </li>
	 <li> 2. you are done. </li>
	 <li> <strong>IMPORTANT : If it's the first time you make this installation, once done, make a git pull from the master branch. The command will be : "git pull origin master" </strong></li>
 </ul>

 <p> <strong>Update your fresh install with latest files from git repository</strong> </p>
 <ul> 
	 <li> 1. open you git bash console or any app you have </li>
	 <li> 2. pull the git master branch and start work :)) </li>
 </ul>
 
 <p><strong>The work flow</strong></p>
 <ul> 
	 <li> If you will be working on a store that allready has a branch, pull the files from it, else you have to create a new brach. </li>
	 <li> Once the branch is created all changes to that store will be made under the branch. No additional branch will be created for the same store even if we work again on it in a few months. </li>
	 <li> &nbsp; </li>
	 <li> For designing a new store or just making changes in an existing one the work will be done in the following folders of magento: </li>
	 <li> Template files : "app/design/frontend/ymall/STORE_NAME" </li>
	 <li> Skin files : "skin/frontend/ymall/STORE_NAME" </li>
	 <li> <strong>IMPORTANT : 
	 	- changes may be required to be done in other sections, but only for adding/changing core functionalities. This will need to be discussed prior and approved. <br/>
	 	- if you have inclarities, found your self stuck or just need info on how to proceed contact Dan : on skype -> dan.lucian-ionut or via email.</strong>
	  </li>
 </ul>
 <p> <strong>The commit names:</strong> Descriptive names to all commits & commit often </p>
