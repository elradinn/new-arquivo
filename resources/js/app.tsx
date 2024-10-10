import "./bootstrap";

import { createRoot } from "react-dom/client";
import { createInertiaApp } from "@inertiajs/react";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

import "@mantine/core/styles.css";
import "@mantine/notifications/styles.css";
import "mantine-datatable/styles.css";
import "@mantine/dropzone/styles.css";

import { theme } from "./theme";

import { MantineProvider } from "@mantine/core";
import { Notifications } from "@mantine/notifications";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.tsx`,
            import.meta.glob("./Pages/**/*.tsx")
        ),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(
            <MantineProvider theme={theme}>
                <Notifications />
                <App {...props} />
            </MantineProvider>
        );

        delete el.dataset.page;
    },
    progress: {
        color: "#4B5563",
    },
}).then(() => {
    document?.getElementById("app")?.removeAttribute("data-page");
});