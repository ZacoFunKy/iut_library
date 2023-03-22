import React, { useState } from "react";

function Connexion() {
  const [formData, setFormData] = useState({
    username: "",
    password: "",
  });

  const handleChange = (event) => {
    setFormData({ ...formData, [event.target.name]: event.target.value });
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    console.log(formData);
  };

  return (
      <div className="flex justify-center text-[#009999] mt-20">
        <form className="pt-6">
          <div className="mb-4 ">
            <h2 className="block  text-4xl font-bold mb-4 text-center">
              Connexion
            </h2>
            <input
              className="border-gray-300 placeholder-[#009999] appearance-none border rounded w-full py-2 px-3  leading-tight focus:outline-none focus:shadow-outline"
              id="username"
              name="username"
              type="text"
              placeholder="Nom"
              value={formData.username}
              onChange={handleChange}
            />
          </div>
          <div class="mb-6">
            <input
              class="border-gray-300 placeholder-[#009999] appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
              id="password"
              name="password"
              type="password"
              placeholder="Mot de passe"
              value={formData.password}
              onChange={handleChange}
            />
          </div>
          <div class="flex items-center justify-between">
            <button
              className="bg-[#009999] hover:bg-[#086969] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              type="button"
              onClick={handleSubmit}
            >
              Se connecter
            </button>
          </div>
        </form>
      </div>
  );
}

export default Connexion;
