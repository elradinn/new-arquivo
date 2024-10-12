import { PageProps } from "@/types";
import { useForm, usePage } from "@inertiajs/react";
import {
    ActionIcon,
    Button,
    Flex,
    Group,
    Modal,
    Select,
    Stack,
    Text,
} from "@mantine/core";
import { useDisclosure } from "@mantine/hooks";
import { notifications } from "@mantine/notifications";
import {
    IconPlus,
    IconTable,
    IconTrash,
} from "@tabler/icons-react";
import { FormEventHandler } from "react";

interface IFormProps {
    isOpened: boolean;
    close: () => void;
}

interface FormData {
    name: string;
    parent_id?: number;
}

const ApprovalForm: React.FC<IFormProps> = ({ isOpened, close }) => {
    const { data, post, processing, reset } =
        useForm<FormData>({
            name: "",
            parent_id: 0,
        });

    const parent_id = usePage<PageProps>().props.folder?.id;

    const createFolderSubmit: FormEventHandler = (e) => {
        e.preventDefault();

        data.parent_id = parent_id;

        post(route("folder.create"), {
            preserveScroll: true,
            onSuccess: () => {
                close();
                notifications.show({
                    message: "Approval process created",
                    color: "green",
                });
            },
            onError: () => {
                close();
                notifications.show({
                    message: "Something went wrong",
                    color: "red",
                });
            },
            onFinish: () => reset(),
        });
    };

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={
                <Text fw="bold" size="lg">
                    Modify Columns
                </Text>
            }
            size={550}
        >
            <form onSubmit={createFolderSubmit}>
                <Stack gap={16}>
                    <Group justify="space-between">
                        <Select
                            placeholder="Pick value"
                            data={["Name", "Numbering", "Date", "Country"]}
                            w="90%"
                        />

                        <ActionIcon color="gray" variant="subtle">
                            <IconTrash size="1rem" />
                        </ActionIcon>
                    </Group>

                    <Group justify="space-between">
                        <Select
                            placeholder="Pick value"
                            data={["Name", "Numbering", "Date", "Country"]}
                            w="90%"
                        />

                        <ActionIcon color="gray" variant="subtle">
                            <IconTrash size="1rem" />
                        </ActionIcon>
                    </Group>

                    <Group justify="space-between">
                        <Select
                            placeholder="Pick value"
                            data={["Name", "Numbering", "Date", "Country"]}
                            w="90%"
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
                            Add New Column
                        </Button>
                    </Flex>
                </Stack>

                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>

                    <Button ml={12} type="submit" loading={processing}>
                        Create
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

const ColumnButton = () => {
    const [
        createApprovalOpened,
        { open: openCreateApproval, close: closeCreateApproval },
    ] = useDisclosure(false);

    return (
        <>
            <Button
                variant="subtle"
                color="dark.3"
                leftSection={<IconTable size={18} />}
                onClick={openCreateApproval}
            >
                Column
            </Button>

            <ApprovalForm
                isOpened={createApprovalOpened}
                close={closeCreateApproval}
            />
        </>
    );
};

export default ColumnButton;
