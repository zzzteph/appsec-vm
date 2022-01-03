package study.appsec.blogger.repository;

import study.appsec.blogger.model.UserRole;
import org.springframework.data.repository.Repository;

public interface UserRoleRepository extends Repository<UserRole, Long> {

    UserRole findByName(String name);

}
