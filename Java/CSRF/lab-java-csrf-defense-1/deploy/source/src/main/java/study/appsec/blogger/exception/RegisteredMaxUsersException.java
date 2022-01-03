package study.appsec.blogger.exception;

public class RegisteredMaxUsersException extends ApplicationException {

    public RegisteredMaxUsersException() {
        super("Cannot register yet another user.");
    }

}
