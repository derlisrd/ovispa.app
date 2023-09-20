import 'dart:convert';

class User{

  final String? username;
  final String email;
  final String token;
  final int id;

  User({
    required this.email, 
    required this.id, 
    required this.token, 
    this.username});

  Map<String,dynamic> toMap(){
    return {
      'username':username,
      'email': email,
      'token': token,
      'id': id
    };
  }

  factory User.fromMap(Map<String, dynamic> map){
    return User(email: map['email'] ?? '', id: map['id'] ?? '', token: map['token'] ?? '', username: map['username'] ?? '');
  }

  String toJson()=> json.encode(toMap());
  
  factory User.fromJson(String cadena )=> User.fromMap(json.decode(cadena));
}