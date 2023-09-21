import 'package:dio/dio.dart';
import 'package:ovispaapp/src/models/login_response.dart';


class ApiCaller {
  final Dio dio = Dio(BaseOptions(
      baseUrl: 'https://ovispa.saeta.app',
      headers: {'x-api-key': 'application/json'})
      );
}
