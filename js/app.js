(function() {
  var app = angular.module('tabla', []);

  app.controller('JugController',['$scope','$http',function($scope, $http){
    $scope.jugadores =[];
    $scope.errors = [];
    $scope.msgs = [];
    $scope.nombre="";
    $scope.equipo="";
    $scope.jugeq =[];    
    $scope.jugselect="";
    $scope.eqselect="";


    

    var getKeyboardEventResult = function (keyEvent, keyEventDesc)
    {
      return (window.event ? keyEvent.keyCode : keyEvent.which);
    };

    $scope.setjug = function(jugador) {
        $scope.jugselect = jugador;
        
        //jugador.price= jugador.price+1;
        //console.log($scope.selected);
    };

    
    $scope.onKeyUp = function ($event) {
      
       console.log("jug"+$scope.jugadores);
    };

    

    $scope.buscar = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        $http.post('post_jugador.php', {'nombre':$scope.nombre}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.jugadores=data.msg;
               // console.log("datmsg"+data.msg);


            }
            else
            {
               $scope.jugadores=data.msg;
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.jugequipo = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        $http.post('post_jugador_equipo.php', {'nombre':$scope.equipo}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.jugeq=data.msg;
               //console.log( data.msg);


            }
            else
            {
               $scope.jugeq=data.msg;
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

   $scope.insjug = function(jug) {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        $http.post('post_insjug.php', {'jugador':jug, 'id':$scope.equipo}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.jugeq=data.msg;
               // console.log("datmsg"+data.msg);
                $scope.jugequipo();


            }
            else
            {
               $scope.jugeq=data.msg;
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

   $scope.titular = function(jug) {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        jug.titular= jug.titular==1?0:1;
        $http.post('post_titular.php', {'jugador':jug}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.jugeq=data.msg;
               // console.log("datmsg"+data.msg);
                $scope.jugequipo();


            }
            else
            {
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };



  }]);


  app.controller('TablaController', ['$scope','$http','$timeout',function($scope,$http,$timeout){
    this.jugadores = jugss;
    $scope.errors = [];
    $scope.msgs = [];
    $scope.torneos=[];
    $scope.torneo="";
    $scope.partidos=[];
    $scope.partido=[];
    this.select='null';
    $scope.ctd = 'false';
    $scope.jugadoresfgd="";
    $scope.idTiempos =[];

    $scope.timerID=0;
    $scope.inicio=true;
    $scope.detener=true;
    $scope.tiempo=new Date();
    $scope.sumaSeg = function(tiempo) {
        t=tiempo.split(":");
        seg =t[2];
        
        seg =parseInt(seg)+1;
        if (parseInt(seg)>59) {
          seg=0;
         tiempo= $scope.sumaMin(tiempo);
        }
        t=tiempo.split(":");

        if (seg<10) {
          tiempo=t[0]+":"+t[1]+":0"+seg;
        }else{
          tiempo=t[0]+":"+t[1]+":"+seg;
        }
       
       return tiempo;
    };
    $scope.sumaMin= function(tiempo) {
        
         t=tiempo.split(":");
        min =t[1];
        
        min =parseInt(min)+1;
        if (parseInt(min)>59) {
          min=0;
         tiempo= $scope.sumaHora(tiempo);
        }
        t=tiempo.split(":");

        if (min<10) {
          tiempo=t[0]+":0"+min+":"+t[2];
        }else{
          tiempo=t[0]+":"+min+":"+t[2];
        }
       
       return tiempo;
    };
    $scope.sumaHora= function(tiempo) {
        
        
         t=tiempo.split(":");
        hora =t[0];
        
        hora =parseInt(hora)+1;
       
        t=tiempo.split(":");

        if (hora<10) {
          tiempo="0"+hora+":"+t[1]+":"+t[2];
        }else{
          tiempo=hora+":"+t[1]+":"+t[2];
        }
       
       return tiempo;
    };
    $scope.iniciarTimer= function() {
      if ($scope.detener) {
        $scope.tiempo="00:00:00";
        
        $scope.detener=false;
        for (index = 0, len = $scope.jugadoresfgd.length; index < len; ++index) {
            $scope.jugadoresfgd[index].tiempo_juego="00:00:00";
            
              console.log(""+$scope.jugadoresfgd[index].tiempo_juego);
            $scope.idTiempos.push({
                idPersona: $scope.jugadoresfgd[index].idPersona,
                activo: true
            })  ;
            console.log($scope.idTiempos);
        }
        };
        $scope.contarTimer();
       // $scope.tiempo=$scope.sumaSeg($scope.tiempo);
        
    };
    $scope.contarTimer= function() {
        
        $scope.tiempo=$scope.sumaSeg($scope.tiempo);
        for (index = 0, len = $scope.jugadoresfgd.length; index < len; ++index) {
          activo=$scope.idTiempos[index].activo;
          if (activo) {
            $scope.jugadoresfgd[index].tiempo_juego=$scope.sumaSeg($scope.jugadoresfgd[index].tiempo_juego);
           console.log("tiempo: "+  $scope.jugadoresfgd[index].tiempo_juego);
          }
            console.log("activo: "+activo+"  "+  $scope.jugadoresfgd[index].idPersona);
            

        }

        $scope.timerID =$timeout(function(){ $scope.contarTimer(); },1000);
        
        
    };
    $scope.detenerTimer= function() {
        
        $timeout.cancel($scope.timerID );
        
        
        
    };
    $scope.detenerJugador= function(jug) {
        
       for (index = 0, len = $scope.jugadoresfgd.length; index < len; ++index) {
          idPersona=$scope.idTiempos[index].idPersona;
            sesuma=$scope.idTiempos[index].activo;
            if (idPersona==jug.idPersona) {

              $scope.idTiempos[index].activo= !sesuma;
              console.log("activo: "+ $scope.idTiempos[index].activo+"id "+$scope.idTiempos[index].idPersona);

            }
            console.log("activo: "+ $scope.idTiempos[index].activo);
            console.log("idPersona: "+ $scope.idTiempos[index].idPersona);
            console.log("idPersona recibido: "+ jug.idPersona);
          
        }
        
        
    };

    var getKeyboardEventResult = function (keyEvent, keyEventDesc)
    {
      return (window.event ? keyEvent.keyCode : keyEvent.which);
    };

    $scope.setSelected = function(tabla,jugador) {
        $scope.selected = this.tabla;
        tabla.select=this.jugador;
        //jugador.price= jugador.price+1;
        //console.log($scope.selected);
    };
    $scope.suma = function(jug,camp,cant) {
      if($scope.ctd!=true){
        jug[camp]=parseInt(jug[camp])+cant;
      }else{
        jug[camp]=parseInt(jug[camp])-cant;
       }
       if (camp=="tiros_1"||camp=="tiros_fallados_1") {
        $scope.calculo(jug);
       }
       if (camp=="tiros_2"||camp=="tiros_fallados_2") {
        $scope.calculo2(jug);
       }
       if (camp=="tiros_3"||camp=="tiros_fallados_3") {
        $scope.calculo3(jug);
       }


    };
    $scope.calculo = function(jug) {
        jug.tiros_por_1=(parseInt(jug.tiros_1)/(parseInt(jug.tiros_1)+parseInt(jug.tiros_fallados_1)))*100; 
    };
    $scope.calculo2 = function(jug) {
        jug.tiros_por_2=(parseInt(jug.tiros_2)/(parseInt(jug.tiros_2)+parseInt(jug.tiros_fallados_2)))*100; 
    };
    $scope.calculo3 = function(jug) {
        jug.tiros_por_3=(parseInt(jug.tiros_3)/(parseInt(jug.tiros_3)+parseInt(jug.tiros_fallados_3)))*100; 
    };
    $scope.onKeyDown = function ($event) {
        var key=getKeyboardEventResult($event, "Key down");
        if( key==17)
        {
           $scope.ctd = true;           
        }
        // window.setTimeout(func1, 250);
    };

    $scope.onKeyUp = function ($event) {
      
      var key=getKeyboardEventResult($event, "Key up");
        if( key==17)
        {
           $scope.ctd= false;          
        }
    };

    

              $scope.SignUp = function() {

                  $scope.errors.splice(0, $scope.errors.length); // remove all error messages
                  $scope.msgs.splice(0, $scope.msgs.length);

                  $http.post('post_es.php', {'uname': $scope.username, 'pswd': $scope.userpassword, 'email': $scope.useremail}
                  ).success(function(data, status, headers, config) {
                      if (data.msg != '')
                      {
                          $scope.msgs.push(data.msg);
                      }
                      else
                      {
                          $scope.errors.push(data.error);
                      }
                  }).error(function(data, status) { // called asynchronously if an error occurs
                                                    // or server returns response with an error status.
                      $scope.errors.push(status);
                  });
              };

    $scope.crpartidos = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_partido.php', {'id':$scope.torneo}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.partidos=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.partidos="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.crequipos = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_partido_equipo.php', {'id':$scope.partido.idPartido}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.equipos=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.equipos="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.jugadoresact = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_jugadoresact.php', {'id':$scope.equipo.idEquipo,'partido':$scope.partido.idPartido}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.jugadoresfgd=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.jugadoresfgd="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.guardar = function() {
      
      for (i =0; i<$scope.jugadoresfgd.length; i++) {
          $scope.savestat($scope.jugadoresfgd[i]);
         // console.log("iteraion: "+ i);
         //  console.log($scope.jugadoresfgd[i]);
        }
      $scope.finalizar();
      //window.location="tablaestafinal.php";


    };
    $scope.savestat = function(jugador) {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_insjugact.php', {'jugador':jugador}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.jugadoresfgd=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.jugadoresfgd="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.finalizar = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_final.php', {'partido':$scope.partido}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.partidofin=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.partidofin="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };



  }]);
  
  //FUTBOL
  
   app.controller('TablaController2', ['$scope','$http',function($scope,$http){
    this.jugadores = jugss;
    $scope.errors = [];
    $scope.msgs = [];
    $scope.torneos=[];
    $scope.torneo="";
    $scope.partidos=[];
    $scope.partido=[];
    this.select='null';
    $scope.ctd = 'false';
    $scope.jugadoresfgd="";

    var getKeyboardEventResult = function (keyEvent, keyEventDesc)
    {
      return (window.event ? keyEvent.keyCode : keyEvent.which);
    };

    $scope.setSelected = function(tabla,jugador) {
        $scope.selected = this.tabla;
        tabla.select=this.jugador;
        //jugador.price= jugador.price+1;
        //console.log($scope.selected);
    };
    $scope.suma = function(jug,camp,cant) {
      if($scope.ctd!=true){
        jug[camp]=parseInt(jug[camp])+cant;
      }else{
        jug[camp]=parseInt(jug[camp])-cant;
       }

    };
    $scope.calculo = function(jug) {
        jug.tiros_por_1=(jug.tiros_1/(jug.tiros_1+jug.tiros_fallados_1))*100; 
    };
    $scope.calculo2 = function(jug) {
        jug.tiros_por_2=(jug.tiros_2/(jug.tiros_2+jug.tiros_fallados_2))*100; 
    };
    $scope.calculo3 = function(jug) {
        jug.tiros_por_3=(jug.tiros_3/(jug.tiros_3+jug.tiros_fallados_3))*100; 
    };
    $scope.onKeyDown = function ($event) {
        var key=getKeyboardEventResult($event, "Key down");
        if( key==17)
        {
           $scope.ctd = true;           
        }
        // window.setTimeout(func1, 250);
    };

    $scope.onKeyUp = function ($event) {
      
      var key=getKeyboardEventResult($event, "Key up");
        if( key==17)
        {
           $scope.ctd= false;          
        }
    };

    

              $scope.SignUp = function() {

                  $scope.errors.splice(0, $scope.errors.length); // remove all error messages
                  $scope.msgs.splice(0, $scope.msgs.length);

                  $http.post('post_es.php', {'uname': $scope.username, 'pswd': $scope.userpassword, 'email': $scope.useremail}
                  ).success(function(data, status, headers, config) {
                      if (data.msg != '')
                      {
                          $scope.msgs.push(data.msg);
                      }
                      else
                      {
                          $scope.errors.push(data.error);
                      }
                  }).error(function(data, status) { // called asynchronously if an error occurs
                                                    // or server returns response with an error status.
                      $scope.errors.push(status);
                  });
              };

    $scope.crpartidos = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_partido.php', {'id':$scope.torneo}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.partidos=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.partidos="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.crequipos = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_partido_equipo.php', {'id':$scope.partido.idPartido}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.equipos=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.equipos="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.jugadoresact = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_jugadoresactfut.php', {'id':$scope.equipo.idEquipo,'partido':$scope.partido.idPartido}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.jugadoresfgd=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.jugadoresfgd="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.guardar = function() {
      
      for (i =0; i<$scope.jugadoresfgd.length; i++) {
          $scope.savestat($scope.jugadoresfgd[i]);
         // console.log("iteraion: "+ i);
         //  console.log($scope.jugadoresfgd[i]);
        }
      $scope.finalizar();
      window.location="tablaestafinal.php";


    };
    $scope.savestat = function(jugador) {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_insjugactfut.php', {'jugador':jugador}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.jugadoresfgd=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.jugadoresfgd="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.finalizar = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_final.php', {'partido':$scope.partido}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.partidofin=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.partidofin="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };



  }]);
  
  //VOLEIBOL
  
   app.controller('TablaController3', ['$scope','$http',function($scope,$http){
    this.jugadores = jugss;
    $scope.errors = [];
    $scope.msgs = [];
    $scope.torneos=[];
    $scope.torneo="";
    $scope.partidos=[];
    $scope.partido=[];
    this.select='null';
    $scope.ctd = 'false';
    $scope.jugadoresfgd="";

    var getKeyboardEventResult = function (keyEvent, keyEventDesc)
    {
      return (window.event ? keyEvent.keyCode : keyEvent.which);
    };

    $scope.setSelected = function(tabla,jugador) {
        $scope.selected = this.tabla;
        tabla.select=this.jugador;
        //jugador.price= jugador.price+1;
        //console.log($scope.selected);
    };
    $scope.suma = function(jug,camp,cant) {
      if($scope.ctd!=true){
        jug[camp]=parseInt(jug[camp])+cant;
      }else{
        jug[camp]=parseInt(jug[camp])-cant;
       }

    };
    $scope.calculo = function(jug) {
        jug.tiros_por_1=(jug.tiros_1/(jug.tiros_1+jug.tiros_fallados_1))*100; 
    };
    $scope.calculo2 = function(jug) {
        jug.tiros_por_2=(jug.tiros_2/(jug.tiros_2+jug.tiros_fallados_2))*100; 
    };
    $scope.calculo3 = function(jug) {
        jug.tiros_por_3=(jug.tiros_3/(jug.tiros_3+jug.tiros_fallados_3))*100; 
    };
    $scope.onKeyDown = function ($event) {
        var key=getKeyboardEventResult($event, "Key down");
        if( key==17)
        {
           $scope.ctd = true;           
        }
        // window.setTimeout(func1, 250);
    };

    $scope.onKeyUp = function ($event) {
      
      var key=getKeyboardEventResult($event, "Key up");
        if( key==17)
        {
           $scope.ctd= false;          
        }
    };

    

              $scope.SignUp = function() {

                  $scope.errors.splice(0, $scope.errors.length); // remove all error messages
                  $scope.msgs.splice(0, $scope.msgs.length);

                  $http.post('post_es.php', {'uname': $scope.username, 'pswd': $scope.userpassword, 'email': $scope.useremail}
                  ).success(function(data, status, headers, config) {
                      if (data.msg != '')
                      {
                          $scope.msgs.push(data.msg);
                      }
                      else
                      {
                          $scope.errors.push(data.error);
                      }
                  }).error(function(data, status) { // called asynchronously if an error occurs
                                                    // or server returns response with an error status.
                      $scope.errors.push(status);
                  });
              };

    $scope.crpartidos = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_partido.php', {'id':$scope.torneo}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.partidos=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.partidos="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.crequipos = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_partido_equipo.php', {'id':$scope.partido.idPartido}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.equipos=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.equipos="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.jugadoresact = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_jugadoresactvol.php', {'id':$scope.equipo.idEquipo,'partido':$scope.partido.idPartido}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.jugadoresfgd=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.jugadoresfgd="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.guardar = function() {
      
      for (i =0; i<$scope.jugadoresfgd.length; i++) {
          $scope.savestat($scope.jugadoresfgd[i]);
         // console.log("iteraion: "+ i);
         //  console.log($scope.jugadoresfgd[i]);
        }
      $scope.finalizar();
      window.location="tablaestafinal.php";


    };
    $scope.savestat = function(jugador) {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_insjugactvol.php', {'jugador':jugador}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.jugadoresfgd=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.jugadoresfgd="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };

    $scope.finalizar = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);
        //console.log("jugad"+$scope.jugadores);
        //console.log("nom"+$scope.nombre);
        
        $http.post('post_final.php', {'partido':$scope.partido}).success(function(data, status, headers, config) {
            if (data.msg != '')
            {
                $scope.partidofin=data.msg;
               // console.log("datmsg"+data.msg);
               
            }
            else
            {
                $scope.partidofin="";
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
                                          // or server returns response with an error status.
            $scope.errors.push(status);
        });
    };



  }]);

 

  var jugss = [{

      nombre: 'Juan',
      pos: 0,
      min: 0,
      fg:0,
      fgpor: 0,
      p3: 0,
      p3por: 0,
      ft: 0,
      ftpor: 0,
      or: 0,
      dr: 0,
      reb: 0,
      as: 0,
      to: 0,
      st: 0,
      bs: 0,
      pf: 0,
      pts: 0,
      eff: 0,
      
    }, {
      nombre: 'Carlos',
      pos: 0,
      min: 0,
      fg:0,
      fgpor: 0,
      p3: 0,
      p3por: 0,
      ft: 0,
      ftpor: 0,
      or: 0,
      dr: 0,
      reb: 0,
      as: 0,
      to: 0,
      st: 0,
      bs: 0,
      pf: 0,
      pts: 0,
      eff: 0,
      
    }, {

      nombre: 'Carlos',
      pos: 0,
      min: 0,
      fg:0,
      fgpor: 0,
      p3: 0,
      p3por: 0,
      ft: 0,
      ftpor: 0,
      or: 0,
      dr: 0,
      reb: 0,
      as: 0,
      to: 0,
      st: 0,
      bs: 0,
      pf: 0,
      pts: 0,
      eff: 0,
      
    }, {
		
	  nombre: 'Jason',
      pos: 0,
      min: 0,
      fg:0,
      fgpor: 0,
      p3: 0,
      p3por: 0,
      ft: 0,
      ftpor: 0,
      or: 0,
      dr: 0,
      reb: 0,
      as: 0,
      to: 0,
      st: 0,
      bs: 0,
      pf: 0,
      pts: 0,
      eff: 0,
      
    }, {
		
      nombre: 'Rodrigo',
      pos: 0,
      min: 0,
      fg:0,
      fgpor: 0,
      p3: 0,
      p3por: 0,
      ft: 0,
      ftpor: 0,
      or: 0,
      dr: 0,
      reb: 0,
      as: 0,
      to: 0,
      st: 0,
      bs: 0,
      pf: 0,
      pts: 0,
      eff: 0,
     }];

})();
