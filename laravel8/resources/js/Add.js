import React from 'react';
import axios from 'axios';
import { Form, Input, Button } from 'antd';
import { useNavigate } from 'react-router-dom';


const { TextArea } = Input;

const Add = ({ history }) => {
    const [form] = Form.useForm();
    const navigate = useNavigate()


    const handleSubmit = (values) => {
        axios
            .post('/posts', values)
            .then((response) => {
              navigate('/hello');
            })
            .catch((error) => {
                console.log(error);
            });
    };


    return (
        <Form
            form={form}
            labelCol={{ span: 5 }}
            wrapperCol={{ span: 12 }}
            onFinish={handleSubmit}
        >
            <Form.Item
                name="title"
                label="Tên bài viết"
                rules={[{ required: true, message: 'Vui lòng nhập tên bài viết!' }]}
            >
                <Input />
            </Form.Item>
            <Form.Item
                name="content"
                label="Nội dung"
                rules={[{ required: true, message: 'Vui lòng nhập nội dung bài viết!' }]}
            >
                <TextArea rows={6} />
            </Form.Item>
            <Form.Item wrapperCol={{ span: 12, offset: 5 }}>
                <Button type="primary" htmlType="submit">
                    Thêm
                </Button>
            </Form.Item>
        </Form>
    );
};

export default Add;
