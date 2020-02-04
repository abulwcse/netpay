import React from 'react';
import PropTypes from 'prop-types';
class ContactForm extends React.Component {
    constructor(props) {
        super(props);
        this.onChangeFormData = this.onChangeFormData.bind(this);
        this.onDelete = this.onDelete.bind(this);
    }
    onDelete() {
        const {
            onDelete,
            id,
        } = this.props;
        onDelete(id);
    }
    onChangeFormData(event) {
        const {
            id,
            onChangeFormData,
        } = this.props;
        onChangeFormData(id, event);
    }
    render() {
        const {
            id,
            data,
        } = this.props;

        const isNameInvalid = typeof data.errors !== 'undefined' && typeof data.errors.name !== 'undefined' && data.errors.name;
        const isEmailInvalid = typeof data.errors !== 'undefined' && typeof data.errors.email !== 'undefined' && data.errors.email;
        const isPhoneInvalid = typeof data.errors !== 'undefined' && typeof data.errors.phone !== 'undefined' && data.errors.phone;
        return (
            <div className='col-sm-6 mt-5'>
                <div className='card bg-light'>
                    <div className='card-block'>
                        <div className='card-title mt-3 ml-2 inline'>
                            Contact
                            <button className='btn btn-danger btn-sm float-right' onClick={this.onDelete}>Delete</button>
                        </div>
                        <hr />
                        <div className={`form-group row ${isNameInvalid ? 'is-invalid' : ''}`}>
                            <label htmlFor={`name_${id}`} className='col-form-label ml-4'>Name</label>
                            <div className='col-sm-10'>
                                <input
                                    type='text'
                                    className={`form-control ${isNameInvalid ? 'is-invalid' : ''}`}
                                    id={`name_${id}`}
                                    name={`name_${id}`}
                                    placeholder='Your name'
                                    value={data.name}
                                    onChange={this.onChangeFormData}
                                    data-id='name'
                                />
                                {isNameInvalid && (
                                    <div className='invalid-feedback'>
                                        Please provide a valid name.
                                    </div>
                                )}
                            </div>
                        </div>
                        <div className={`form-group row ${isEmailInvalid ? 'is-invalid' : ''}`}>
                            <label htmlFor={`email_${id}`} className='col-form-label ml-4'>Email</label>
                            <div className='col-sm-10'>
                                <input
                                    type='email'
                                    className={`form-control ${isEmailInvalid ? 'is-invalid' : ''}`}
                                    id={`email_${id}`}
                                    name={`email_${id}`}
                                    placeholder='name@example.com'
                                    value={data.email}
                                    onChange={this.onChangeFormData}
                                    data-id='email'
                                />
                                {isEmailInvalid && (
                                    <div className='invalid-feedback'>
                                        Please provide a valid email address.
                                    </div>
                                )}
                            </div>
                        </div>
                        <div className={`form-group row ${isPhoneInvalid ? 'is-invalid' : ''}`}>
                            <label htmlFor={`phone_${id}`} className='col-form-label ml-4'>Phone</label>
                            <div className='col-sm-10'>
                                <input
                                    type='tel'
                                    className={`form-control ${isPhoneInvalid ? 'is-invalid' : ''}`}
                                    id={`phone_${id}`}
                                    name={`phone_${id}`}
                                    placeholder='0123456789'
                                    value={data.phone}
                                    onChange={this.onChangeFormData}
                                    data-id='phone'
                                />
                                {isPhoneInvalid && (
                                    <div className='invalid-feedback'>
                                        Please provide a valid phone number.
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
ContactForm.propTypes = {
    id: PropTypes.string.isRequired,
    // eslint-disable-next-line react/forbid-prop-types
    data: PropTypes.object.isRequired,
    onChangeFormData: PropTypes.func.isRequired,
    onDelete: PropTypes.func.isRequired,
};
ContactForm.defaultProps = {
    data: {},
};
export default ContactForm;