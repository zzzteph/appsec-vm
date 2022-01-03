package com.backend.ssti.Repository;

import com.backend.ssti.DAO.Blog;
import org.springframework.stereotype.Repository;
import org.springframework.data.jpa.repository.JpaRepository;

@Repository
public interface BlogRepository extends JpaRepository<Blog, String>{
}
