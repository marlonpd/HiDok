<div class="user-modal-container" class="user-modal-container active" id="login-modal" @click="close">
  <div class="user-modal">
    <ul class="form-switcher">
      <li @click="flip('register', $event)"><a href="" id="register-form">Register</a>

      </li>
      <li @click="flip('login', $event)"><a href="" id="login-form">Login</a>

      </li>
    </ul>
    <div class="form-register" :class="{ 'active': active == 'register' }" id="form-register">
      <div class="error-message" v-text="registerError"></div>
      <input type="text" name="name" placeholder="Name" v-model="registerName" @keyup.enter="submit('register', $event)">
      <input type="email" name="email" placeholder="Email" v-model="registerEmail" @keyup.enter="submit('register', $event)">
      <input type="password" name="password" placeholder="Password" v-model="registerPassword" @keyup.enter="submit('register', $event)">
      <input type="submit" :class="{ 'disabled': submitted == 'register' }" @click="submit('register', $event)" v-model="registerSubmit" id="registerSubmit">
      <div class="links"> <a href="" @click="flip('login', $event)">Already have an account?</a>

      </div>
    </div>
    <div class="form-login" :class="{ 'active': active == 'login' }" id="form-login">
      <div class="error-message" v-text="loginError"></div>
      <input type="text" name="user" placeholder="Email or Username" v-model="loginUser" @keyup.enter="submit('login', $event)">
      <input type="password" name="password" placeholder="Password" v-model="loginPassword" @keyup.enter="submit('login', $event)">
      <input type="submit" :class="{ 'disabled': submitted == 'login' }" @click="submit('login', $event)" v-model="loginSubmit" id="loginSubmit">
      <div class="links"> <a href="" @click="flip('password', $event)">Forgot your password?</a>

      </div>
    </div>
    <div class="form-password" :class="{ 'active': active == 'password' }" id="form-password">
      <div class="error-message" v-text="passwordError"></div>
      <input type="text" name="email" placeholder="Email" v-model="passwordEmail" @keyup.enter="submit('password', $event)">
      <input type="submit" :class="{ 'disabled': submitted == 'password' }" @click="submit('password', $event)" v-model="passwordSubmit" id="passwordSubmit">
    </div>
  </div>
</div>