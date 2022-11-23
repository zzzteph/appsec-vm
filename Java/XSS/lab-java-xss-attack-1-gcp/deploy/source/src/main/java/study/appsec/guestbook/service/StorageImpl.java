package study.appsec.guestbook.service;

import study.appsec.guestbook.exception.ApplicationException;
import study.appsec.guestbook.model.Comment;
import org.springframework.stereotype.Service;

import javax.annotation.PostConstruct;
import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

@Service
public class StorageImpl implements Storage {

    private final List<Comment> comments = new ArrayList<>();

    @PostConstruct
    private void init() {
        add(new Comment("Anonym", "You're amazing! Please, never give up!"));
        add(new Comment("SomebodyWhoLovesCookies", "Is here any cookie? Chocolate or vanilla?"));
    }

    @Override
    public void add(Comment comment) {
        if (comment.getName() == null || comment.getName().length() == 0 ||
            comment.getMessage() == null || comment.getMessage().length() == 0) {
            throw new ApplicationException("Comment is invalid. Please, fill in all the data.");
        }
        comments.add(comment);
    }

    @Override
    public List<Comment> listLast(int limit) {
        int size = comments.size();
        List<Comment> result = new ArrayList<>(size < limit ? comments : comments.subList(size - limit, size));
        Collections.reverse(result);
        return result;
    }

}
