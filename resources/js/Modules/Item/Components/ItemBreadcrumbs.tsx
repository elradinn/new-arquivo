import { Link } from "@inertiajs/react";
import { Anchor, Breadcrumbs } from "@mantine/core";
import { IconChevronRight } from "@tabler/icons-react";

interface BreadcrumbProps {
    ancestors: { id: string; name: string }[];
}

export default function ItemBreadcrumbs({ ancestors }: BreadcrumbProps) {
    const breadcrumbItems = ancestors
        .slice(1)
        .map((ans) => (
            <Anchor component={Link} href={`/folder/index/${ans.id}`} key={ans.id}>
                {ans.name}
            </Anchor>
        ));

    return (
        <Breadcrumbs separator={<IconChevronRight size={16} />}>
            {breadcrumbItems}
        </Breadcrumbs>
    );
}