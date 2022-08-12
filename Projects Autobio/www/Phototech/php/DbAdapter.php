<? 
  class DbAdapter {
    private $serverName;
    private $dataBase;
    private $userName;
    private $password;
    public $connection;

    function __construct(string $serverName = "localhost", string $dataBase = "slkhv's_photo_gallery",
    string $userName = "root", string $password = "") {
      $this -> serverName = $serverName;
      $this -> dataBase = $dataBase;
      $this -> userName = $userName;
      $this -> password = $password;
    }

    function connect() {
      $connection = mysqli_connect($this -> serverName, $this -> userName, $this -> password, $this -> dataBase);
      $this -> connection = $connection;
      $this -> isConnectionAlive();
    }

    function isConnectionAlive() {
      if (!$this -> connection) 
        die("Connection failed: " . mysqli_connect_error());
    }

    function initializeDB() {
      //$createDb = "CREATE DATABASE IF NOT EXISTS `slkhv's_photo_gallery` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
      $createTableCategory = "CREATE TABLE `category` (`id` int(11) NOT NULL, `name` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
      $createTableImages = "CREATE TABLE `images` (`id` int(11) NOT NULL, `category_id` int(11) NOT NULL, `subcategory_id` int(11) NOT NULL, `path` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
      $createTableSubCategory = "CREATE TABLE `subcategory` ( `id` int(11) NOT NULL, `name` text NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
      
      $addPrimaryKeyCategory = "ALTER TABLE `category` ADD PRIMARY KEY (`id`);";
      $addPrimaryKeyImages = "ALTER TABLE `images` ADD PRIMARY KEY (`id`), ADD KEY `category_id` (`category_id`), ADD KEY `subcategory_id` (`subcategory_id`);";
      $addPrimaryKeySubCategory = "ALTER TABLE `subcategory` ADD PRIMARY KEY (`id`);";

      $autoIncrementCategory = "ALTER TABLE `category` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT";
      $autoIncrementImages = "ALTER TABLE `images` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
      $autoIncrementSubCategory = "ALTER TABLE `subcategory` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";
      
      $addForeignKeysImages = "ALTER TABLE `images` ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON UPDATE CASCADE, ADD CONSTRAINT `images_ibfk_2` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`id`) ON UPDATE CASCADE;";
      
      $this -> isConnectionAlive();
      
      $tableCount = mysqli_query($this -> connection, "SELECT COUNT(DISTINCT `table_name`) FROM `information_schema`.`columns` WHERE `table_schema` = $this -> dataBase");

      if (!(int) $tableCount == 0)
        die("Creating failed: DB is NOT NULL, to continue replace 46 - 47 line (it may be another line, please check)");

      mysqli_multi_query($this -> connection, $createTableCategory + $createTableImages + $createTableSubCategory +
      $addPrimaryKeyCategory + $addPrimaryKeyImages + $addPrimaryKeySubCategory + 
      $autoIncrementCategory + $autoIncrementImages + $autoIncrementSubCategory +
      $addForeignKeysImages); 
    }

    function insert(string $command) {
      $this -> isConnectionAlive();
      if(!mysqli_query($this -> connection, $command))
        die(mysqli_error($this -> connection));
      return true;
    }
  }

  $dBConnection = new DbAdapter();
  $dBConnection -> connect();
?>