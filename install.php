<?php if(isset($_POST['submit'])): ?>
<?php
Load::_class("packages_data");
$resource = new Data(HOST,USER,PASSWORD,DATABASE);

$sql = "CREATE  TABLE IF NOT EXISTS `user` (`user_id` INT NOT NULL AUTO_INCREMENT , `user_name` VARCHAR(45) NULL , `user_about` TEXT NULL , `user_email` VARCHAR(45) NULL , `user_password` VARCHAR(45) NULL , `user_forgot` VARCHAR(45) NULL , PRIMARY KEY (`user_id`) ) ENGINE = MyISAM DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;";
$install = $resource->go($sql);
if($install)
    //echo "1";
    $sql = "CREATE  TABLE IF NOT EXISTS `states` (`states_id` INT NOT NULL AUTO_INCREMENT , `states_name` VARCHAR(45) NULL , `states_description` VARCHAR(45) NULL , `states_image` VARCHAR(45) NULL , `states_active` INT NULL , PRIMARY KEY (`states_id`) ) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci";
    $install = $resource->go($sql);
    if($install)
        
        $sql = "CREATE  TABLE IF NOT EXISTS `publish` (`publish_id` INT NOT NULL AUTO_INCREMENT , `publish_text` TEXT NULL , `publish_register` DATETIME NULL , `publish_states` INT NULL , `publish_owner` INT NULL , PRIMARY KEY (`publish_id`) , INDEX `publish_states_id` (`publish_states` ASC) , CONSTRAINT `publish_states_id` FOREIGN KEY (`publish_states` ) REFERENCES `states` (`states_id` ) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci";
        $install = $resource->go($sql);
        if($install)

            $sql = "CREATE  TABLE IF NOT EXISTS `register` (`register_id` INT NOT NULL AUTO_INCREMENT , `register_date` DATETIME NULL , `register_states` INT NULL , PRIMARY KEY (`register_id`) ,INDEX `register_states_id` (`register_states` ASC) ,CONSTRAINT `states_id` FOREIGN KEY (`register_states` ) REFERENCES `states` (`states_id` ) ON DELETE CASCADE ON UPDATE CASCADE) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci";
            $install = $resource->go($sql);
            if($install)

                //echo "PERFECTO";
                $sql = "INSERT INTO user VALUES(NULL, '{$_POST['name']}', '{$_POST['about']}', '{$_POST['email']}', MD5('{$_POST['password']}'), '')";
                $user = $resource->go($sql);
                if($user)
                    //echo $url = URL;

                    $sql = "INSERT INTO states VALUES(NULL,'{$_POST['state_name']}','{$_POST['state_description']}', '', 1)";
                    $state = $resource->go($sql);
                    if($state)
                        $sql = "SELECT LAST_INSERT_ID() AS states_id";
                        $state = $resource->go($sql);
                        if($state)

                            $state = mysql_fetch_array($state);
                            $sql = "INSERT INTO register VALUES(NULL,NOW(),{$state['states_id']})";
                            $register = $resource->go($sql);
                            if($register)
                                $url = URL;
                                header("location: $url");
?>
<?php else: ?>
<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>User install</title>
        <script type="text/javascript" src="<?php echo URL ?>/skin/jquery-1.3.2.min.js"></script>        
        <script type="text/javascript" src="<?php echo URL ?>/skin/jquery.validate.min.js"></script>
        <script type="text/javascript">        
        <!-- 
        	$(document).ready(function(){                    
                    $('form').validate({
                        rules: {
                            name: "required",
                            about: "required",
                            password: "required",
                            password_confirm: {
                                    required: true,
                                    equalTo: "#password"
                            },
                            email: {
                              required: true,
                              email: true
                            },
                            state_name: "required",
                            state_description: "required"
                        },
                        messages: {
                            name: "",
                            about: "",
                            password: "",
                            password_confirm: {
                                    required: "",
                                    equalTo: ""
                            },
                            email: {
                              required: "",
                              email: ""
                            },
                            state_name: "",
                            state_description: ""
                        }
                    });
                		
        	})
       	-->
        </script>        
        <style type="text/css">
            body{
                margin: 0;
                font: 12px Tahoma, Geneva, sans-serif;
            }
            #page{
                margin: 20px auto;
                padding: 20px;
                width: 500px;
                background: #EEE;
                border: 1px solid #AAA;
            }
            h1{
                margin: 0;
                font-size: 24px;
                font-weight: normal;
                color: #666;
}
h2{
    color: #999;
    margin: 0;
    font-size: 18px;
    font-weight: normal;
}
small{
    font: 10px;
}
form{
    margin: 0;
}
form p{
	position: relative;
}
form label{
    float: left;
    margin: 0 5px 0 0;
    width: 150px;
    color: #999;
    text-align: right;
}
form input, form textarea{
    border: 1px solid #AAA;
    padding: 5px 0;
}
form fieldset{  
    border: none;    
}
form legend{
    display: none;
    font-weight: bold;
}
form h2{
    padding: 5px 0;
    border-bottom: 1px dashed #AAA;
}
form #btn-submit{
    background: #FFF;
    cursor: pointer;
}
label.error{
	position: absolute;
	top: 0;
	right: 0;
	color: #C00;
}
input.error, textarea.error{
    border: 1px dotted red;
}
        </style>        
    </head>
    <body>
        <div id="page">
            <h1>Install</h1>
            <small>Bienvenido al asistente de instalaci&oacute;n de User, Tan sol&oacute; le tomara 10 segundos para empezar a disfrutar del sistema.</small>
            <form action="<?php echo URL ?>/index.php" method="post">
                    
                <h2>Datos de acceso:</h2>
                <p>
                    <label for="name">Nombre Completo:</label>
                    <input type="text" name="name" style="width: 55%;" />
                </p>
                <p>
                    <label for="about">Acerca de mi:</label>
                    <textarea name="about" cols="5" rows="4" style="width: 55%;"></textarea>
                </p>
                <p>
                    <label for="email">Correo electronico:</label>
                    <input type="text" name="email" style="width: 55%;" re />
                </p>
                <p>
                    <label for="password">Contrase&ntilde;a:</label>
                    <input type="password" id="password" name="password" style="width: 55%;" />
                </p>
                <p>
                    <label for="password_confirm">Confirmar contrase&ntilde;a:</label>
                    <input type="password" name="password_confirm" style="width: 55%;" />
                </p>
                <h2>Estado inicial:</h2>
                <p>
                    <label for="state-name">Estado:</label>
                    <input type="text" name="state_name" style="width: 55%;" />
                </p>
                <p>
                    <label for="state-description">Descripci&oacute;n:</label>
                    <textarea name="state_description" cols="5" rows="4" style="width: 55%;"></textarea>
                </p>
                <p style="margin-left: 155px;">
                    <input type="submit" name="submit" value="Install..." id="btn-submit" />
                </p>
            </form>
        </div>
    </body>
</html>
<?php endif ?>