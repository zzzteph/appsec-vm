package study.appsec.blogger.repository;

import study.appsec.blogger.model.User;
import org.springframework.data.repository.Repository;

public interface UserRepository extends Repository<User, Long> {

    User findByUsername(String username);

    User findById(Long id);

    int count();

}
