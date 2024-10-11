import { router } from "@inertiajs/react";

export function useOpenFolder() {
    const openFolder = (is_folder: number, id: string) => {
        if (!is_folder) {
            return;
        }
        router.visit(route("index", { id }));
    };

    return { openFolder };
}