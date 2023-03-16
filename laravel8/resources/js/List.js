import React, { useState, useEffect,useCallback } from 'react';
import axios from 'axios';
import { Modal, Button , Form , Input ,message } from 'antd';
const PostList = () => {
  const [form] = Form.useForm();
  const [posts, setPosts] = useState([]);
  const [modalVisible, setModalVisible] = useState(false);
  const [postIdToDelete, setPostIdToDelete] = useState(null);
  const [deletedPostIds, setDeletedPostIds] = useState([]);

  const [postEditId,setPostIdEdit]= useState([]);
  const [visible, setVisible] = useState(false);
  const [editPostData, setEditPostData] = useState({
    title: "",
    content: "",
  });
  const [count, setCount] = useState(0);


  const updatePosts = useCallback((data) => {
    setPosts(data);
  }, []);
  
  useEffect(() => {
    axios.get('/posts')
      .then(response => {
        updatePosts(response.data);
      })
      .catch(error => {
        console.log(error);
      });
  }, [updatePosts,count]);
  
  const handleDeletePost = (postId) => {
    setPostIdToDelete(postId);
    setModalVisible(true);
  };

  const handleEditPost = (postId) =>{
    setVisible(true);
    setPostIdEdit(postId);
    let response = null;
    axios.get(`/posts/${postId}`)
    .then(res => {
      response = res.data;
    
      setEditPostData({
        content: response.content,
        title: response.title,
      });
    })
    .catch(error => {
      console.log(error);
    });
  }



  const handleOk = () => {
    setModalVisible(false); // ẩn modal đi khi xóa thành công
    setDeletedPostIds([...deletedPostIds, postIdToDelete]);
    axios.delete(`/posts/${postIdToDelete}`)
      .then(response => {
        setPosts(posts.filter(post => post.id !== postIdToDelete));
      })
      .catch(error => {
        console.log(error);
      });
  };

  const handleEditOk = () => {
    const data = {
      title: editPostData.title,
      content: editPostData.content,
    };
    setVisible(false);

    axios
    .patch(`/posts/${postEditId}`, data)
    .then((response) => {

      if (response.status === 200) {
        message.success("Cập nhật bài viết thành công Hehe");
        setCount(count + 1)
      } else {
          if (error.response && error.response.status === 400) {
            message.error("Dữ liệu không hợp lệ");
          } else if (error.response && error.response.status === 404) {
            message.error("Không tìm thấy bài viết");
          } else {
            message.error(`Cập nhật bài viết thất bại: ${error.message}`);
          }
      }
    })
  };
  
  const handleInputChange = (event) => {
  
    const { name, value } = event.target;

    setEditPostData((editPostData) => ({
      ...editPostData,
      [name]: value,
    }));
  };
  
  const onEditCancel = () => {
    setVisible(false);
  };


  const handleCancel = () => {
    setModalVisible(false);
  };

  


  return (
    <table  style={{ width: "50%" }}>
    <thead>
      <tr>
        <th>Danh sách bài viết</th>
      </tr>
    </thead>
    <tbody>
    {posts.map((post, index) => {
  // Kiểm tra xem bài viết có id trong danh sách deleteIds hay không
  const isDeleting = deletedPostIds.includes(post.id);
  return (
    <>
      {index === 0 && (
        <tr>
          <th style={{textAlign:"center"}}>Number</th>
          <th>Title</th>
          <th>Content</th>
        </tr>
      )}
      <tr key={post.id} style={{ display: isDeleting ? 'none' : 'table-row' }}>
        <td  style={{ width: "25%" , textAlign:"center" }}>{index + 1}</td>
        <td >{post.title}</td>
        <td >{post.content}</td>
        <td>{!isDeleting && (
          <><button className="btn btn-danger" onClick={() => handleDeletePost(post.id)} >Xóa</button>
          <button style={{paddingLeft: '5%'}} className="btn btn-primary" onClick={() => handleEditPost(post.id)}>Edit</button></>
        )}</td>
      </tr>
    </>
  );
})}
    </tbody>
    <Modal
      title="Xác nhận xóa"
      visible={modalVisible}
      onOk={handleOk}
      onCancel={handleCancel}
    >
      <p>Bạn có chắc muốn xóa bài viết này không?</p>
    </Modal>

    <Modal
      title="Chỉnh sửa bài viết"
      visible={visible}
      onOk={handleEditOk}
      onCancel={onEditCancel}
      destroyOnClose={true}
    >
      <Form form={form} layout="vertical">
        <Form.Item name="title" label="Tiêu đề" type="text"  onChange={handleInputChange} rules={[{ required: true, message: 'Vui lòng nhập tiêu đề' }]}>
          <Input name="title" placeholder={editPostData.title} rules={[{ required: true, message: 'Vui lòng nhập tiêu đề' }]}/>
        </Form.Item>
        <Form.Item name="content" label="Nội dung" placeholder={editPostData.content} onChange={handleInputChange} rules={[{ required: true, message: 'Vui lòng nhập nội dung' }]}>
          <Input.TextArea name="content" placeholder={editPostData.content} rules={[{ required: true, message: 'Vui lòng nhập nội dung' }]}/>
        </Form.Item>
      </Form>
    </Modal>
  </table>
  
  );
};

export default PostList;
