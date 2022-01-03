package study.appsec.blogger.repository;

import study.appsec.blogger.model.Post;
import study.appsec.blogger.model.User;
import org.springframework.data.repository.Repository;

import java.util.List;

public interface PostRepository extends Repository<Post, Long> {

    Post findById(Long id);

    List<Post> findAllByOrderByDateUpdatedDesc();

    List<Post> findAllByUser(User user);

}
