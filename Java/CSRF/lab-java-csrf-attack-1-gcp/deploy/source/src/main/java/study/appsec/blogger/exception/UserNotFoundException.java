package study.appsec.blogger.exception;

public class UserNotFoundException extends ApplicationException {

    public UserNotFoundException() {
        super("User not found.");
    }

}
