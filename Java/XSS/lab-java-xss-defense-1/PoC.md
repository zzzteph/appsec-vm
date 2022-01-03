#Флаг
XSS_JAVA_SHIED_VIPER


# POC


2. Найти (59-60 строки)

                        <p><b><span th:remove="tag" th:utext="${comment.name}"></span></b></p>
                        <p><span th:remove="tag" th:utext="${comment.message}"></span></p>
					
					
Заменить на(utext->text)					
                        <p><b><span th:remove="tag" th:text="${comment.name}"></span></b></p>
                        <p><span th:remove="tag" th:text="${comment.message}"></span></p>