import { router } from "@inertiajs/react";

export function useOpenFolder() {
    const openFolder = (type: string, id: string) => {
        if (type !== "folder") {
            return;
        }
        router.visit(route("folder", { id }));
    };

    return { openFolder };
}