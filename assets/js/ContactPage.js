import React from 'react';
import ContactForm from './ContactForm';
import {isValidEmail, isAlphabetic, isNumberOnly} from './helper';
import _ from 'lodash';

class ContactPage extends React.Component {
    constructor(props) {
        super(props);
        this.id = 1;
        this.state = {
            formData: {},
        };
        this.addNewContactForm = this.addNewContactForm.bind(this);
        this.onChangeFormData = this.onChangeFormData.bind(this);
        this.onDeleteContact = this.onDeleteContact.bind(this);
        this.onClickValidate = this.onClickValidate.bind(this);
        this.onFormSubmit = this.onFormSubmit.bind(this);
    }
    componentDidMount() {
        let fallbackData = document.getElementById('fallback-data').value;
        fallbackData = JSON.parse(fallbackData);
        if (Object.keys(fallbackData).length > 0) {
            this.setState({
                formData: fallbackData
            });
            this.id = parseInt(_.max(Object.keys(fallbackData))) + 1;
            return;
        }
        const {
            formData,
        } = this.state;
        formData[this.id] = {
            name: '',
            email: '',
            phone: '',
            errors: [],
        };
        this.id += 1;
        this.setState({
            formData,
        });
    }

    onFormSubmit() {
        let form = ReactDOM.findDOMNode(this.refs.mainForm);
        form.submit()
    }

    onClickValidate() {
        const {
            formData,
        } = this.state;
        Object.keys(formData).forEach((key) => {
            formData[key].errors = {
                name: !isAlphabetic(formData[key].name),
                email: !isValidEmail(formData[key].email),
                phone: !isNumberOnly(formData[key].phone)
            };
        });
        this.setState({
            formData,
        });
    }
    onDeleteContact(formID) {
        const {
            formData,
        } = this.state;
        if (typeof formData[formID] === 'undefined') {
            return;
        }
        delete formData[formID];
        this.setState({
            formData,
        });
    }
    onChangeFormData(formID, event) {
        const {
            formData,
        } = this.state;
        if (typeof formData[formID] === 'undefined') {
            return;
        }
        switch (event.target.dataset.id) {
            case 'name':
                formData[formID].name = event.target.value;
                break;
            case 'email':
                formData[formID].email = event.target.value;
                break;
            case 'phone':
                formData[formID].phone = event.target.value;
                break;
            default:
                break;
        }
        this.setState({
            formData,
        });
    }
    addNewContactForm() {
        const {
            formData,
        } = this.state;
        formData[this.id] = {
            name: '',
            email: '',
            phone: '',
        };
        this.id += 1;
        this.setState({
            formData,
        });
    }
    render() {
        const {
            formData,
        } = this.state;
        return (
            <div>
                <div className='row'>
                    <div className='col-lg-12'>
                        <h2 className='d-inline-block'>Multi Contact form</h2>
                        <button className='btn active btn-primary float-right btn-space' type='submit' form='main-form'>Save</button>
                        <button className='btn active btn-success float-right btn-space' onClick={this.onClickValidate}>Validate</button>
                        <button className='btn active btn-secondary float-right btn-space' onClick={this.addNewContactForm}>Add Contact</button>
                    </div>
                </div>
                <hr />
                <form id='main-form' method='post'>
                    <div id='contact-form' className='row'>
                        {Object.keys(formData).reverse().map((key) => {
                            const data = formData[key];
                            return (
                                <ContactForm
                                    id={key}
                                    key={key}
                                    onChangeFormData={this.onChangeFormData}
                                    data={data}
                                    onDelete={this.onDeleteContact}
                                />
                            );
                        })}
                    </div>
                    <input type="hidden" value={JSON.stringify(formData)} name="data"/>
                </form>
            </div>
        );
    }
}
export default ContactPage;