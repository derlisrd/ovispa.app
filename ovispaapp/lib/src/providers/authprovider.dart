import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:ovispaapp/src/models/user.dart';

import 'package:shared_preferences/shared_preferences.dart';


class AuthProvider extends ChangeNotifier {
  bool _isAuth = false;
  User? _user;

  User? get user => _user;
  bool get isAuth => _isAuth;

  final dio = Dio(BaseOptions(baseUrl: 'https://ovispa.saeta.app',headers: {'x-api-key':'s9d1e5xx'}));
  

  void setUser(String userParams){
    _user = User.fromJson(userParams);
    notifyListeners();
  }

  void setUserFromModel(User usermodel){
    _user = usermodel;
    notifyListeners();
  }


  Future<void> login(String email,String pass) async{
    try {
      final response = await dio.post('/auth/login',data: {"email":email,"password":pass});
      final data = response.data;
      if(data['success'] == true && response.statusCode == 200){
        final SharedPreferences local = await SharedPreferences.getInstance();
        local.setString('token',response.data['results']['token']);
        _user = User(email: data['results']['email'], id: data['results']['id'], token: data['results']['token']);
        _isAuth = true;
        notifyListeners();
      }else{
        throw Exception('Credenciales incorrectas');
      }
    } catch (e) {
      throw Exception(e);
    }
  }

  Future<void> checkAuthStatus()async{
    final local = await SharedPreferences.getInstance();
    final token = local.getString('token');

    if(token != null){
      final response = await dio.post('/auth/check',options: Options(headers: {'Authorization': 'Bearer $token'}));
      final data = response.data;
      if(data['success'] == true && response.statusCode == 200){
        _isAuth = true;
        notifyListeners();
      }
    }
  }

  Future<bool> logout() async{
    final SharedPreferences local = await SharedPreferences.getInstance();
    local.remove('token');
    _isAuth = false;
    notifyListeners();
    return true;
  }


  
}