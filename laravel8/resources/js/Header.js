import React from 'react';
import { Link } from 'react-router-dom';
import { PageHeader, Button } from 'antd';

class Header extends React.Component {
    render() {
        return (
            <div>
                <PageHeader
                    title="Bài viết"
                    breadcrumb={{
                        routes: [
                            {
                                path: 'index',
                                breadcrumbName: 'Bài viết',
                            },
                        ],
                    }}
                    extra={[
                        <Link to='create'>
                            <Button key="1" type="primary">
                                Thêm bài viết
                            </Button>
                        </Link>
                    ]}
                />
            </div>
        );
    }
}

export default Header;
