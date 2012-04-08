<?php echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>" ?>
<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Usuario: <?php echo User::$name ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo URL ?>/skin/style.css" />
        <script src="<?php echo URL ?>/skin/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script src="<?php echo URL ?>/skin/jquery.validate.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            <!--
            $(document).ready(function(){
                $('a.show').toggle(function(){                    
                    $element = $(this).attr('href');
                    $($element).show();
                },function(){
                    $element = $(this).attr('href');
                    $($element).hide();
                })

                $('.entry').hover(function(){
                    $(this).find('ul:first').show();
                },function(){
                    $(this).find('ul:first').hide();
                })

                $('.entry-wrapper:first').append('<div class="entry-bullet"></div>').css("font-size","24px");

                $('.entry-delete').click(function(event){
                    $id = $(event.target).attr('href');
                    $.ajax({
                        url: '<?php echo URL ?>/publish/delete',
                        data: 'token=<?php echo User::$token ?>&id=' + $id,
                        type: "POST",
                        success: function(html){                            
                            if(html == "200"){                                
                                $(event.target).parent().parent().parent().parent().parent().fadeOut("slow");
                            }
                        }
                    })
                    
                    return false;
                })

                $('.show-tooltip').hover(function(){
                              
                   	if($(this).find('.tooltip:first').is(":hidden")){  
                       	//alert("Si");
						$(this).find('.tooltip').show();						
                   	}
                    
                }, function(){
                	$(this).find('.tooltip').hide();
                })

                $('#state-active').hover(function(){
					$('#state-actions').show();
                },function(){
                	$('#state-actions').hide();
                })

                $('.state-active').click(function(event){                    
                    $id = $(event.target).attr("href").substring(1,2);                    
                    $.ajax({
                        url: "<?php echo URL ?>/states/put",
                        type: "POST",
                        data: "token=<?php echo User::$token ?>&states_active=1&states_id="+$id+"&response=html",
                        success: function(html){
                            alert(html);
                            if(html == 200){
                                document.location('./');
                            }
                        }
                    })
                    return false;
                })
                /*$('html').click(function(){
					$('.window').hide();
					$('.window-up').hide();
                })*/

                $('#login_validate').validate({
                    rules: {
                        name: "required",
                        password: "required"
                    },
                    messages: {
                        name: "",
                        password: ""
                    }

                })
                $('#publish_validate').validate({
                    rules: {
                        publish_text: "required"
                    },
                    messages: {
                        publish_text: ""
                    }

                })
                $('#state_validate').validate({
                    rules: {
                        state_name: "required",
                        state_description: "required"
                    },
                    messages: {
                        state_name: "",
                        state_description: ""
                    }
                })
                $('#image_validate').validate({
                    rules: {
                        image: "required"
                    },
                    messages: {
                        image: ""
                    }
                })                                
            })
            -->
        </script>
    </head>
    <body>
        <div id="page">
            <div id="user-actions">
                <ul>
                    <li>
                        <a href="#publish" id="show-publish" class="show">Acciones</a>
                        <div id="publish" class="window">
                            <h1><span>Publicar</span></h1>
                            <div class="window-wrapper">
                                <form action="<?php echo URL ?>/publish" method="post" id="publish_validate">
                                    <?php if(User::$token): ?>
                                        <input type="hidden" name="token" value="<?php echo User::$token ?>" />                                        
                                    <?php endif ?>
                                    <input type="hidden" name="state" value="<?php echo User::$state_active['id'] ?>" />
                                    <p>
                                        <textarea name="publish_text" cols="5" rows="4" style="width: 98%;"></textarea>
                                    </p>
                                    <p>
                                        <input type="submit" value="Dilo..." />
                                    </p>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div id="user">                
                <div id="state-active" class="states">
                    <img src="<?php if(User::$state_active['image']): ?><?php echo URL ?>/pics/<?php echo User::$state_active['image'] ?><?php else: ?><?php echo URL ?>/skin/images/user.gif<?php endif ?>" alt="Javier Jaimes Trabajando..." />
                    <h1><strong><?php echo User::$name ?></strong> esta <?php echo User::$state_active['name'] ?></h1>
                    <?php if(User::$token): ?>
                    <ul id="state-actions">
                        <li><a href="#imagen-upload" class="show">cambiar imagen</a>
                            <div id="imagen-upload" class="window">
                                <div class="window-wrapper">
                                    <h1><span>Cambiar la imagen</span></h1>
                                    <form action="<?php echo URL ?>/states/put" method="post" enctype="multipart/form-data" id="image_validate">
                                        <?php if(User::$token): ?>
                                            <input type="hidden" name="token" value="<?php echo User::$token ?>" />
                                            <input type="hidden" name="states_id" value="<?php echo User::$state_active['id'] ?>" />
                                        <?php endif ?>
                                        <p>
                                            <input type="file" name="image" />
                                        </p>
                                        <p>
                                            <input type="submit" value="Cargar..." class="btn-submit" />
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <?php endif ?>
                </div>
                <div id="states">                    
                    <ul>
                        <?php //print_r(User::$states) ?>
                        <?php if(User::$states_num > 1): ?>
                        <?php foreach(User::$states as $key => $state): ?>
                        <li class="show-tooltip">
                            <a href="<?php echo URL ?>/?state=<?php echo $state['id'] ?>" rel="<?php echo  $state['id'] ?>"><span><?php echo $key + 1 ?></span></a>
                            <div class="tooltip"><div class="tooltip-wrapper"><small><span>Estado:</span><?php echo $state['name'] ?> <?php if(User::$token and $state['id'] != User::$state_active['id']): ?>(<a href="#<?php echo $state['id'] ?>" class="state-active">activar</a>|<a href="<?php echo URL ?>/states/delete/?&token=<?php echo User::$token ?>&amp;id=<?php echo $state['id'] ?>" class="state-delete">eliminar</a>)<?php endif; ?></small></div></div>
                        </li>
                        <?php endforeach ?>
                        <?php else: ?>
                        <li class="show-tooltip">
                            <a href="<?php echo URL ?>/?state=<?php echo User::$states['id'] ?>" rel="<?php echo  User::$states['id'] ?>"><span>1</span></a>
                            <div class="tooltip"><div class="tooltip-wrapper"><small><span>Estado:</span><?php echo User::$states['name'] ?> <?php if(User::$token && User::$state_active['id'] != 1): ?>(<a href="#<?php echo User::$states['id'] ?>" class="state-active">activar</a>|<a href="#<?php echo User::$states['id'] ?>" class="state-delete">eliminar</a>)<?php endif; ?></small></div></div>
                        </li>
                        <?php endif ?>
                        <?php if(User::$token): ?>
                            <li>
                                <a href="#states-create" class="show"><span>+</span></a>
                                <div id="states-create" class="window">
                                    <h1><span>Estados:</span></h1>
                                    <div class="window-wrapper">                                        
                                        <form action="<?php echo URL ?>/states" class="user" method="post" id="state_validate">
                                            <h2>Nuevo estado</h2>
                                            <input type="hidden" name="token" value="<?php echo User::$token ?>" />
                                            <p>
                                                <label for="state_name">Estado:</label>
                                                <input type="text" name="state_name" style="width: 60%;"  />
                                            </p>
                                            <p>
                                                <label for="state_description">Descripci&oacute;n:</label>
                                                <textarea name="state_description" cols="5" rows="4" style="width: 60%;"></textarea>
                                            </p>
                                            <p style="margin-left: 95px;">
                                                <input type="submit" name="submit" value="Crear" id="btn-submit" />
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
            <div id="wall">                
                <?php if(User::$published_num > 1): ?>
                <?php foreach(User::$published as $key => $published): ?>
                <div class="entry-wrapper <?php if(!$published['owner']): ?>visit<?php endif ?>">
                    <div class="entry-width">
                        <div class="entry"><p><?php echo $published['text'] ?></p><?php if(User::$token): ?><ul class="entry-actions"><li><a href="#<?php echo $published['id'] ?>" class="entry-delete">eliminar</a></li></ul><?php endif ?></div>
                    </div>     
                </div>
                <?php endforeach ?>
                <?php else: ?>
                <?php if(User::$published_num > 0):?>
                <div class="entry-wrapper">
                    <div class="entry-bullet"></div>
                    <div class="entry-width">
                        <div class="entry"><p><?php echo User::$published['text'] ?></p><?php if(User::$token): ?><ul class="entry-actions"><li><a href="#<?php echo User::$published['id'] ?>" class="entry-delete">eliminar</a></li></ul><?php endif ?></div>
                    </div>
                </div>
                <?php else: ?>
                <div class="entry-wrapper">
                    <div class="entry-bullet"></div>
                    <div class="entry-width">
                        <div class="entry"><p><?php echo User::$name ?> no tiene publicaciones por compartir.</p></div>
                    </div>
                </div>
                <?php endif ?>
                <?php endif ?>                
            </div>
            <div id="final">
                <ul>
                    <li><a href="#me" class="show">Poder por <strong>Me!</strong></a>.
                        <div id="me" class="window-up">
                            <div class="window-wrapper">
                                <h1><span>Me no es un CMS!</span></h1>
                                <p>Me es una idea de Se&ntilde;or Pasajero para compartir con sus amigos lo que hace en cada instante, no queria un sitio web tradicional, fue lo primero que pens&oacute;.</p>
                                <p>El desarrollo de Me! llevo aproximadamente 96 horas para un total de m&aacute;s 1000 lineas de c&oacute;digo. Me! requiere Php 5.0 y Mysql 5.0 para su correcto funcionamiento.</p>
                                <p>Me! es de c&oacute;digo abierto, cualquier colaboraci&oacute;n sera bien recibida. Es facil de instalar y sus librerias en su mayoria son propiedad del autor.</p>
                            </div>
                        </div>
                    </li>
                    <li><a href="<?php echo URL ?>/feed">Sigueme <strong>(rss)</strong></a>.</li>
                    <li><a href="#use" class="show">&iquest;Interesado en usarlo?</a>
                        <div id="use" class="window-up">
                            <div class="window-wrapper">
                                <h1><span>Me es gratuito!</span></h1>
                                <p>Me es de uso libre para personas, para un uso comercial se recomienda contactar al autor. Si te gusta la idea se puede rese&ntilde;ar, divulgar y compartir esta idea. En caso de alguna donaci&oacute;n no duden en contactar al autor.</p>
                                <p><a href="#">Click aqui para descargar Me! 1.0</a></p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <?php if(User::$token): ?>
                            <a href="<?php echo URL ?>/access/logout">Salir</a>
                        <?php else: ?>

                            <a href="#login" class="show">Acceder</a>
                            <?php if(isset($_GET['login_error'])): ?>
                            <div id="forgot" class="window-up" style="display: block;">
                                <div class="window-wrapper">
                                    <h1><span>Reestablecer acceso</span></h1>
                                    <form action="<?php echo URL ?>/access/reset" method="post">
                                        <p>
                                            <label for="email">Correo electronico:</label>
                                            <input type="text" name="email" />
                                        </p>
                                        <p>
                                            <input type="submit" value="Reset" class="btn-submit" />
                                        </p>
                                    </form>
                                </div>
                            </div>
                            <?php endif ?>
                            
                            <div id="login" class="window-up">
                            <div class="window-wrapper">
                                <h1><span>Conectarse</span></h1>
                                <form action="<?php echo URL ?>/access/login" method="post" id="login_validate">
                                    <p>
                                        <label for="name">Nombre:</label>
                                        <input type="text" name="name" />
                                    </p>
                                    <p>
                                        <label for="password">Contrase&ntilde;a:</label>
                                        <input type="password" name="password" />
                                    </p>
                                    <p>
                                        <input type="submit" id="btn-submit" value="Conectar..." />
                                    </p>
                                </form>
                            </div>
                        </div>
                        <?php endif ?>
                    </li>
                </ul>                
            </div>
        </div>
    </body>
</html>
