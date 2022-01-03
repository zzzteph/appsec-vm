package com.backend.ssti.Service;

import com.backend.ssti.DAO.Blog;
import com.backend.ssti.Repository.BlogRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class BlogService {

    @Autowired
    private BlogRepository blogRepository;

    public void save(String name, String message){
        blogRepository.save(new Blog(name, message));
    }

    public List<Blog> findAll(){
        return blogRepository.findAll();
    }
}
