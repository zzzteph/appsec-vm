package study.appsec.blogger.exception;

public class PostNotFoundException extends ApplicationException {

    public PostNotFoundException() {
        super("Post not found.");
    }

}
