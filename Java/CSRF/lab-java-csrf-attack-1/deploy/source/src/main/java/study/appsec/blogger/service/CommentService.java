package study.appsec.blogger.service;

import study.appsec.blogger.model.Comment;
import study.appsec.blogger.model.Post;
import study.appsec.blogger.model.User;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import javax.persistence.EntityManager;
import java.util.Date;

@Service
@RequiredArgsConstructor
public class CommentService {

    private final EntityManager entityManager;

    @Transactional
    public void createComment(Post post, User user, String text) {
        Comment comment = new Comment();
        comment.setPost(post).setUser(user).setText(text).setDateCreated(new Date());
        entityManager.persist(comment);
        entityManager.flush();
    }

}
