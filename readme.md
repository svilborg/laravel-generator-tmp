
## Laravel Generator Template App

Skeleton for Laravel Generator with Token authentications.

Laravel Generator + Ide Helper + Samples + From Table - Swagger (too broken)

Different branches contain :

- Generic
- Generic + Sample Data
- Custom API Token Authentication
- JWT Token Authentication
- OAuth2 Authentication

### Generic

git clone https://github.com/svilborg/laravel-generator-tmp.git


### Sample Data (No Authnetication)

git clone -b sample-data https://github.com/svilborg/laravel-generator-tmp.git

```
php artisan infyom:api_scaffold Item
```

http://labs.infyom.com/laravelgenerator/docs/5.6/getting-started

### Custom API Token Auth

git clone -b api-token-auth https://github.com/svilborg/laravel-generator-tmp.git

```
http://127.0.0.1:8000/api/items?access_token=test
```


### JWT Token Authentication

git clone -b jwt-token-auth https://github.com/svilborg/laravel-generator-tmp.git


- Login

```
http://127.0.0.1:8000/api/login?email=qqq@test.com&password=qqqqqq
```

- Issue Token

```
http://127.0.0.1:8000/api/items?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTUyNTc4NzU1MSwiZXhwIjoxNTI1NzkxMTUxLCJuYmYiOjE1MjU3ODc1NTEsImp0aSI6Im81RUUxWXFDWENsWXVGM2oiLCJzdWIiOjQsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.AP8msKX-VuUkD3W6gPoQeQZpSOSE_p4aurHlp38Zipk
```

- Refresh Token

```
http://127.0.0.1:8000/api/refresh?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTUyNTc5Mjk4MCwiZXhwIjoxNTI1NzkzMTAwLCJuYmYiOjE1MjU3OTI5ODAsImp0aSI6ImJLWnRXYXkzcW41blpVQjgiLCJzdWIiOjQsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.Eoy0ysWsJu0bqw8AKdrIYQlbVmPpfOeuYRRKRlugqfQ
```

### Authentication Oauth2

git clone -b api-auth https://github.com/svilborg/laravel-generator-tmp.git



Issue Token

```
artisan test:token
```

Issue Refresh Token

```
artisan test:refresh def50200a65ad1fe55c540230b64e60b8c55a127b30f9d35eafda70a03719f92e5c78dabe2c59f201afac24a2124fe7520cfeb7173a8d87c94831d08f2f79f25513a94d99a0a6622fb4b5a5c69ad4580bc550e7f69e3d2e7b3b4e40940420cbad86606b95c92c73a7c7ea54d41361930cfb75a12b447f8c74634a31d2b659bb2c0fb83a74b709da6e4545c59a45ba701e3207652d81e18c3b9cf9566348e1170502c391569e7978d507bccc2d190230f832c3277a5621e6ded2f7ea8e629bde2f3a013b48b29bf4a19070b354fd045e68414e872ff7204c4f9e4d04eb0bb81deb7407d17736eab054431e7841b074fcd42ea5ecb821de5c90693dac7c88d6ee9bde3cece7059487b144ed376089ee8878827ae5853b160d3ed91746fd26f641966be9331f8e9a3d1839bf0e5b3932979e4b753a7957e5a9ce69519b4a8cf1b72142c9ed147b8780e6f9c756d7cd233499cf9f71552d84b702690ad802ad46e7dc506fdad
```

Resource Request

```
http http://localhost:8000/api/items 'Accept:application/json' 'Authorization:Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImFhYTNiMWNjN2JjMzM5MTMzMmMyMTE4ZjI0YWU2ZDMyMjc3YzI0NDI0MjE0ZjI2NTNjZjZmOTAwN2FlZjczMzNjMDBmMzQ5Yzc5YWNhNDNmIn0.eyJhdWQiOiIzIiwianRpIjoiYWFhM2IxY2M3YmMzMzkxMzMyYzIxMThmMjRhZTZkMzIyNzdjMjQ0MjQyMTRmMjY1M2NmNmY5MDA3YWVmNzMzM2MwMGYzNDljNzlhY2E0M2YiLCJpYXQiOjE1MjU3MDc3NTAsIm5iZiI6MTUyNTcwNzc1MCwiZXhwIjoxNTI1NzA4MzUwLCJzdWIiOiI0Iiwic2NvcGVzIjpbIioiXX0.R7C1VVSgF9E7-KZwexSmu-vdr6EYOdjwTAPrsGOuONNsXwq_UlhRgF1GfMCuCuLLO-_0SB51PPy7BcUlDVrnlz6RueLMDTCPaluv0OsYBs4QeZv8iE2rxDE3S-5-QlNnsNeFlGiN0RPWmtyOArAh85I3d1hu1gusw_owLQm0oskM0pr7c2CcqMZjQCzAq4KV-MLtULyJHd0RcktWF8ONzgRHHZ5GWsQVuOSwgehD-CX_nMhlVn3yeE9UB7MUlVTjHtbH1HYaujZuCTHxzcmifd-cw7IBvqtd8b3n7IkngurUFR5p9R-2BtroM-PM_kFD6ovDFK1xcGsU1U56_rbQpIwIWBwpl4JXHPMpOMb6uaPI1Y6ilDBPP62RHzpzw93S-jbKxA_E6mKXFHbCSvQdmVhJVlHxXJ8G-mgtyBow49bRODZqN7hEUKzsc3dz8SohPHHdQKFhiqBv__qGjLRBfZAxcW8vN4WiWDRyvJCVmsr4B8vlV1XZIWqQicPUdDbN_xfNGnnW_7-JSfeTn64KafvYxBZJBRdpXa5Mu97AwO3pcIOSJI4NznEGoUyxbLdcDyvCE3U_8mvyFxvsdvtquhJnLBPdhCVTStwiwjuxMRly0E-OwxCWLf_JQEI5Km_LMB7o1OH1pACj-YYCxdPPYvWTOPcZhdlik3U6c--uCtY
```

Test Clients

```
Encryption keys generated successfully.
Personal access client created successfully.
Client ID: 1
Client Secret: ecV9gIiqlmtuQtispVh6xJwkFGCXcHjpngLoW3Mj
Password grant client created successfully.
Client ID: 2
Client Secret: It8O8Hw68uH2uzq14MBfdGjKkoIYy4wUYJrnyavm
```

```
Client ID: 3
Client secret: fWSn2MuCq3sIcN35bSe4Qq1fpreKi0ndKVS2rZh4
```
