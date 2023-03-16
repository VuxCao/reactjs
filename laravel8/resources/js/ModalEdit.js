import { Modal, Form, Input, Button } from 'antd';

const EditPostModal = ({ visible, onOk, onCancel, initialValues }) => {

    const [postData, setPostData] = useState({});

  const handleInputChange = (event) => {
    setPostData({ ...postData, [event.target.name]: event.target.value });
  };

  // Thiết lập giá trị mặc định của form từ initialValues

  useEffect(() => {
    axios.get(`/posts/${postId}`)
      .then(response => {
        setPostData(response.data);
      })
      .catch(error => {
        console.log(error);
      });
  }, []);

  const handleOk = () => {
    form.validateFields()
      .then(values => {
        // Gọi API để update post
        axios.delete(`/posts/${postIdToDelete}`)
        onOk(values);
      })
      .catch(error => {
        console.log(error);
      });
  };

  return (
    <Modal
      title="Chỉnh sửa bài viết"
      visible={visible}
      onOk={handleOk}
      onCancel={onCancel}
      destroyOnClose={true}
    >
      <Form form={form} layout="vertical"  onFinish={handleSubmit}>
        <Form.Item name="title" label="Tiêu đề"  value={postData.title} onChange={handleInputChange} rules={[{ required: true, message: 'Vui lòng nhập tiêu đề' }]}>
          <Input />
        </Form.Item>
        <Form.Item name="content" label="Nội dung" value={postData.content} onChange={handleInputChange} rules={[{ required: true, message: 'Vui lòng nhập nội dung' }]}>
          <Input.TextArea />
        </Form.Item>
      </Form>
    </Modal>
  );
};

export default EditPostModal;
