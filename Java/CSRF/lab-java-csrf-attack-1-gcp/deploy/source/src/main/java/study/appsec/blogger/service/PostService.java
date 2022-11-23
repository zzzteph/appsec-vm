package study.appsec.blogger.service;

import study.appsec.blogger.exception.ApplicationException;
import study.appsec.blogger.model.Opinion;
import study.appsec.blogger.model.Post;
import study.appsec.blogger.model.User;
import study.appsec.blogger.model.UserRole;
import study.appsec.blogger.repository.OpinionRepository;
import study.appsec.blogger.repository.PostRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import javax.persistence.EntityManager;
import java.util.Date;
import java.util.List;
import java.util.Optional;

@Service
@RequiredArgsConstructor
public class PostService {

    private final PostRepository postRepository;
    private final OpinionRepository opinionRepository;
    private final EntityManager entityManager;

    @Transactional(readOnly = true)
    public List<Post> getAll() {
        return postRepository.findAllByOrderByDateUpdatedDesc();
    }

    @Transactional(readOnly = true)
    public List<Post> getUserPosts(User user) {
        return postRepository.findAllByUser(user);
    }

    @Transactional(readOnly = true)
    public Post getById(Long id) {
        Post post = postRepository.findById(id);
        if (post == null) {
            throw new ApplicationException("Post with id " + id + " not found.");
        }
        return post;
    }

    @Transactional(readOnly = true)
    public boolean isUserCanEditPost(User user, Post post) {
        boolean isOwner = post.getUser().equals(user);
        boolean isAdmin = user != null && user.hasRole(UserRole.ROLE_ADMIN);
        return isOwner || isAdmin;
    }

    @Transactional(readOnly = true)
    public void updatePostRating(Post post) {
        post.setRating(opinionRepository.calculatePostRating(post));
    }

    @Transactional(readOnly = true)
    public void updatePostsRating(List<Post> posts) {
        posts.forEach(this::updatePostRating);
    }

    @Transactional(readOnly = true)
    public int getUserOpinion(Post post, User user) {
        Optional<Opinion> opt = opinionRepository.findByPostAndUser(post, user);
        return opt.isPresent() ? opt.get().getValue() : 0;
    }

    @Transactional
    public void updatePost(Post post, User user, String title, String text) {
        if (post.getId() == null) {
            post.setUser(user).setDateCreated(new Date());
        }
        if (!isUserCanEditPost(user, post)) {
            throw new ApplicationException("You cannot update this post.");
        }
        post.setTitle(title).setText(text).setDateUpdated(new Date());
        entityManager.persist(post);
        entityManager.flush();
    }

    @Transactional
    public void deletePost(Post post, User user) {
        if (!isUserCanEditPost(user, post)) {
            throw new ApplicationException("You cannot delete this post.");
        }
        entityManager.remove(post);
        entityManager.flush();
    }

}
