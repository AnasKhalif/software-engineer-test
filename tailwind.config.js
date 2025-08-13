import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Outfit", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: "#f2f6ff",
                    100: "#e6efff",
                    500: "#1f4ed8",
                    600: "#1842c0",
                    700: "#12379f",
                },
                body: "#f5f7fc",
            },
            boxShadow: {
                card: "0 1px 2px rgba(16,24,40,.05),0 0 0 1px rgba(16,24,40,.06)",
            },
        },
    },
    plugins: [],
};
