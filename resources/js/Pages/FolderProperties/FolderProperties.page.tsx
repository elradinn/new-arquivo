import { Head, Link } from "@inertiajs/react";
import { PageProps } from "@/types";
import {
    ActionIcon,
    Anchor,
    Breadcrumbs,
    Button,
    Flex,
    Group,
    Stack,
    Text,
    Textarea,
    TextInput,
} from "@mantine/core";
import { Authenticated } from "@/Modules/Common/Layouts/AuthenticatedLayout/Authenticated";
import {
    IconChevronRight,
    IconEdit,
    IconFile,
    IconFolder,
    IconPlus,
    IconTrash,
} from "@tabler/icons-react";
import Toolbar from "@/Modules/Common/Components/Toolbar/Toolbar";

interface FolderPropertiesProps extends PageProps {
    data: {
        name: string;
        path: string;
    };
}

export default function FolderPropertiesPage({ auth, data, ancestors }: any) {
    // const breadcrumbItems = ancestors.data.map((ans) =>
    //     !ans.parent_id ? (
    //         <Anchor component={Link} href={route("index")} key={ans.id}>
    //             Home
    //         </Anchor>
    //     ) : (
    //         <Anchor component={Link} href={`/folder/index/${ans.id}`} key={ans.id}>
    //             {ans.name}
    //         </Anchor>
    //     ),
    // );

    return (
        <Authenticated toolbar={<Toolbar page="trash" />}>
            <Head title={"folder name"} />
            <Stack px={8} py={8} gap={24} w={550} mb={72}>
                {/* <Breadcrumbs separator={<IconChevronRight size={16} />}>
                    {breadcrumbItems}
                </Breadcrumbs> */}

                <Group mt={24}>
                    <IconFolder size={56} fill="orange" stroke="none" color="none" />
                    <Text fw={500}>{"folder name"}</Text>
                    <ActionIcon variant="subtle" color="gray">
                        <IconEdit size={24} />
                    </ActionIcon>
                </Group>

                <TextInput id="name" type="text" name="document_number" label="Document Number" />

                <TextInput id="tags" type="text" name="tags" label="Tags" />

                {/* <Textarea label="Notes" autosize minRows={4} maxRows={6} defaultValue={data.path} /> */}

                <Stack gap={12}>
                    <Text size="sm" fw={500}>
                        Custom Metadata Field
                    </Text>

                    <Group justify="space-between">
                        <TextInput
                            id="name"
                            type="text"
                            name="document_number"
                            value="Country"
                            readOnly
                        />

                        <TextInput
                            id="name"
                            type="text"
                            name="document_number"
                            defaultValue="Belgium"
                        />

                        <ActionIcon color="gray" variant="subtle">
                            <IconTrash size="1rem" />
                        </ActionIcon>
                    </Group>

                    <Group justify="space-between">
                        <TextInput
                            id="name"
                            type="text"
                            name="document_number"
                            value="Application Type"
                            readOnly
                        />

                        <TextInput
                            id="name"
                            type="text"
                            name="document_number"
                            defaultValue="Outbound"
                        />

                        <ActionIcon color="gray" variant="subtle">
                            <IconTrash size="1rem" />
                        </ActionIcon>
                    </Group>

                    <Flex justify="flex-start">
                        <Button
                            variant="subtle"
                            color="blue.5"
                            leftSection={<IconPlus size={18} />}
                        >
                            Add Metadata
                        </Button>
                    </Flex>
                </Stack>

                <Stack gap={12}>
                    <Text size="sm" fw={500}>
                        Related Files
                    </Text>

                    <Group justify="space-between">
                        <Group>
                            <IconFolder size={28} fill="orange" stroke={1.5} color="orange" />
                            <Text size="sm" fw={400}>
                                Projects
                            </Text>
                        </Group>

                        <ActionIcon color="gray" variant="subtle">
                            <IconTrash size="1rem" />
                        </ActionIcon>
                    </Group>

                    <Group justify="space-between">
                        <Group>
                            <IconFile size={28} stroke={1.5} color="gray" />
                            <Text size="sm" fw={400}>
                                Sample Document.pdf
                            </Text>
                        </Group>

                        <ActionIcon color="gray" variant="subtle">
                            <IconTrash size="1rem" />
                        </ActionIcon>
                    </Group>

                    <Flex justify="flex-start">
                        <Button
                            variant="subtle"
                            color="blue.5"
                            leftSection={<IconPlus size={18} />}
                        >
                            Add Related File
                        </Button>
                    </Flex>
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit">
                        Save
                    </Button>
                </Flex>
            </Stack>
        </Authenticated>
    );
}
