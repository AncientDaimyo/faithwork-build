// userStore.js
import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
  state: () => ({
    email: localStorage.getItem("userEmail") || "",
    password: localStorage.getItem("userPassword") || "",
    loggedIn: localStorage.getItem("loggedIn") === "true",
    firstName: localStorage.getItem("userFirstName") || " ",
    lastName: localStorage.getItem("userLastName") || " ",
    birthdate: localStorage.getItem("userBirthdate") || "",
    phone: localStorage.getItem("userPhone") || "",
    newsletter: localStorage.getItem("userNewsletter") === "true",
  }),

  actions: {
    setUserData({ email, password, firstName, lastName, birthdate, phone, newsletter }) {
      this.email = email;
      this.password = password;
      this.firstName = firstName;
      this.lastName = lastName;
      this.birthdate = birthdate;
      this.phone = phone;
      this.newsletter = newsletter;
      this.loggedIn = true;
      
      localStorage.setItem("userEmail", email);
      localStorage.setItem("userPassword", password);
      localStorage.setItem("userFirstName", firstName);
      localStorage.setItem("userLastName", lastName);
      localStorage.setItem("userBirthdate", birthdate);
      localStorage.setItem("userPhone", phone);
      localStorage.setItem("userNewsletter", JSON.stringify(newsletter));
      localStorage.setItem("loggedIn", JSON.stringify(true));
    },

    clearUserData() {
      // Удаляем только состояние входа, но сохраняем данные пользователя
      this.loggedIn = false;
      localStorage.setItem("loggedIn", JSON.stringify(false));
    },

    login(email, password) {
      const storedEmail = localStorage.getItem("userEmail");
      const storedPassword = localStorage.getItem("userPassword");
      if (
        storedEmail &&
        storedPassword &&
        email === storedEmail &&
        password === storedPassword
      ) {
        this.loggedIn = true;
        localStorage.setItem("loggedIn", JSON.stringify(true)); // Сохраняем состояние входа
        return true;
      } else {
        return false;
      }
    },

    checkUserData(email, password) {
      const storedEmail = localStorage.getItem("userEmail");
      const storedPassword = localStorage.getItem("userPassword");
      return email === storedEmail && password === storedPassword;
    },

    logout() {
      this.loggedIn = false;
      localStorage.setItem("loggedIn", JSON.stringify(false));
    },
  },

  getters: {
    isRegistered: (state) => !!state.email && !!state.password,
    isLoggedIn: (state) => state.loggedIn,
    userData: (state) => ({
      email: state.email,
      password: state.password,
      firstName: state.firstName,
      lastName: state.lastName,
      birthdate: state.birthdate,
      phone: state.phone,
      newsletter: state.newsletter,
    }),
  },
});