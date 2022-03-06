import { useState } from 'react';
import classes from './Login.module.css';

function Login(props) {
    useState();

    return (
        <form className={classes.form}>
            <div>
                <label htmlFor='username'>Username</label>
                <input type="text" required id="username" className={classes.spacing}/>
            </div>
            <div className={classes.input}>
                <label htmlFor='password'>Password</label>
                <input type="text" required id="password" className={classes.spacing}/>
            </div>
            <div className={classes.button}>
                <button>Login</button>
            </div>
        </form>
    );
}

export default Login;