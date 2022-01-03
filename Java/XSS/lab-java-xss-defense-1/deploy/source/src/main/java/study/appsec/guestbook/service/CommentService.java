package study.appsec.guestbook.service;

import study.appsec.guestbook.model.Comment;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;

import java.util.ArrayList;
import java.util.List;

@Service
@RequiredArgsConstructor
public class CommentService {

    private final Storage storage;

    public List<Comment> getLastFive() {
        List<Comment> comments = new ArrayList<>();
        storage.listLast(5).forEach(comment -> comments.add(new Comment(
            comment.getName(), comment.getMessage()
        )));
        return comments;
    }

}
