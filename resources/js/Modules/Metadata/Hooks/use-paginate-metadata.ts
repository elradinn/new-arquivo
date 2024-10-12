import { useState } from "react";
import { router } from "@inertiajs/react";

export function useMetadataPagination(initialPage: number) {
    const [page, setPage] = useState(initialPage);

    const handlePageChange = (page: number, links: { label: string; url: string }[]) => {
        setPage(page);
        const newUrl = links.find((link) => link.label === page.toString())?.url;
        if (newUrl) {
            router.visit(newUrl);
        }
    };

    return { page, setPage, handlePageChange };
}