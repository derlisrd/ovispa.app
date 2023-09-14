import 'package:flutter/material.dart';
import '../screens/screens.dart';

class AppRoutes {
  
  Map<String,WidgetBuilder> rutas (BuildContext context){

    return {
      LoginScreen.routeName :(context) => const LoginScreen(),
      '/register':(context) => const RegisterScreen(),
    };
  }  
}