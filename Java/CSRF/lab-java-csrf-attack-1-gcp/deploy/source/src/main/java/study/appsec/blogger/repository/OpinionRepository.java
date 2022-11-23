package study.appsec.blogger.repository;

import study.appsec.blogger.model.Opinion;
import study.appsec.blogger.model.Post;
import study.appsec.blogger.model.User;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.Repository;
import org.springframework.data.repository.query.Param;

import java.util.Optional;

public interface OpinionRepository extends Repository<Opinion, Long> {

    Optional<Opinion> findByPostAndUser(Post post, User user);

    @Query("SELECT COALESCE(SUM(o.value), 0) FROM Opinion o WHERE o.post = :post AND o.value > 0")
    int calculatePostRating(@Param("post") Post post);

}
