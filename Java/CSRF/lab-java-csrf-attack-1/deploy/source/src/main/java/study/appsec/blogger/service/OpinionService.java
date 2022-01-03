package study.appsec.blogger.service;

import study.appsec.blogger.model.Opinion;
import study.appsec.blogger.model.Post;
import study.appsec.blogger.model.User;
import study.appsec.blogger.repository.OpinionRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import javax.persistence.EntityManager;
import java.util.Optional;

@Service
@RequiredArgsConstructor
public class OpinionService {

    private final OpinionRepository opinionRepository;
    private final EntityManager entityManager;

    @Transactional
    public void setOpinion(Post post, User user, int opinionValue) {
        Optional<Opinion> opinionOptional = opinionRepository.findByPostAndUser(post, user);
        Opinion opinion = opinionOptional.orElseGet(() -> new Opinion().setPost(post).setUser(user));
        opinion.setValue(opinionValue > 0 ? 1 : -1);
        entityManager.persist(opinion);
        entityManager.flush();
    }

}
